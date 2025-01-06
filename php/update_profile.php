<?php
require_once '../db/config.php';
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]){
    $user_id = $_SESSION['user_id'];
} else {
    echo "<p>Si è verificato un errore. Sarai reindirizzato alla homepage tra 3 secondi.</p>";
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = '../homepage.php';
                            }, 3000);
                          </script>";
                    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = trim($_POST["firstname"]);
    $last = trim($_POST["lastname"]);
    $user = trim($_POST["username"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;

    $errors = [];
    
    if(empty($first)) {
        $errors[] = "Il nome è obbligatorio.";
    } elseif (strlen($first) > 30) {
        $errors[] = "Il nome non può superare i 30 caratteri.";
    }

    if(empty($last)) {
        $errors[] = "Il cognome è obbligatorio.";
    } elseif (strlen($last) > 30) {
        $errors[] = "Il cognome non può superare i 30 caratteri.";
    }

    if (strlen($user) > 20) {
        $errors[] = "Lo username non può superare i 20 caratteri.";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'indirizzo email è mancante o non è valido.";
    } elseif (strlen($email) > 50) {
        $errors[] = "L'indirizzo email non può superare i 50 caratteri.";
    }

    if (isEmailAvailable($conn, $email, $user_id)) {
        $errors[] = "L'indirizzo email è già in uso.";
    }

    if (!empty($errors)) {
        echo json_encode(["errors" => $errors]);
        exit();
    }

    $query = "UPDATE users SET first_name = ?, last_name = ?, user_name = ?, email = ?, newsletter = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssii", $first, $last, $user, $email, $newsletter, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Aggiornamento del profilo avvenuto con successo. Sarai reindirizzato al tuo profilo tra 3 secondi.</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '../show_profile.php';
                    }, 3000);
                  </script>";
            exit();
        } else {
            echo json_encode(["error" => "Errore durante l'aggiornamento del profilo."]);
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["error" => "Errore nella preparazione della query."]);
        exit();
    }

    mysqli_close($conn);
}

function isEmailAvailable($conn, $email, $user_id) {
    $query = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $email, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $row_count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    return $row_count > 0;
}
?>
