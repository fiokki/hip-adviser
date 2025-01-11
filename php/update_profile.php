<?php
require_once '../db/config.php';
include_once '../layout-elements/head.php';
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]){
    $user_id = $_SESSION['user_id'];
} else {
    echo "<p>Si è verificato un errore. Sarai reindirizzato alla homepage tra 2 secondi.</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = '../homepage.php';
        }, 2000);
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
        $errors[] = "Il nome &eacute obbligatorio.";
    } elseif (strlen($first) > 30) {
        $errors[] = "Il nome non puo' superare i 30 caratteri.";
    }

    if(empty($last)) {
        $errors[] = "Il cognome &eacute obbligatorio.";
    } elseif (strlen($last) > 30) {
        $errors[] = "Il cognome non puo' superare i 30 caratteri.";
    }

    if (strlen($user) > 20) {
        $errors[] = "Lo username non puo' superare i 20 caratteri.";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'indirizzo email &eacute mancante o non &eacute valido.";
    } elseif (strlen($email) > 50) {
        $errors[] = "L'indirizzo email non puo' superare i 50 caratteri.";
    }

    if (isEmailAvailable($conn, $email, $user_id)) {
        $errors[] = "L'indirizzo email &eacute gia' in uso.";
    }

    if (!empty($errors)) {
        echo "<p>" . implode("<br>", $errors) . "</p>";
        echo "<p> Sarai reindirizzato alla pagina del tuo profilo tra 2 secondi. </p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '.show_profile.php';
                }, 2000);
              </script>";
        exit();
    }

    $query = "UPDATE users SET first_name = ?, last_name = ?, user_name = ?, email = ?, newsletter = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssii", $first, $last, $user, $email, $newsletter, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Aggiornamento del profilo avvenuto con successo. Sarai reindirizzato al tuo profilo tra 2 secondi.</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'show_profile.php';
                    }, 2000);
                  </script>";
            exit();
        } else {
            echo "<p>Errore durante l'aggiornamento del profilo. Sarai reindirizzato al tuo profilo tra 2 secondi.</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'show_profile.php';
                    }, 2000);
                  </script>";
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p>Errore nella preparazione della query. Sarai reindirizzato al tuo profilo tra 2 secondi. </p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'show_profile.php';
                }, 2000);
              </script>";
        exit();
    }

    mysqli_close($conn);
}
else{
    echo "<p>Si è verificato un errore. Sarai reindirizzato alla homepage tra 2 secondi.</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = '../homepage.php';
        }, 2000);
    </script>";
    exit();
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
