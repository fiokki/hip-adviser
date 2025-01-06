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
    $oldPassword = trim($_POST["oldPassword"]);
    $newPassword = trim($_POST["newPassword"]);
    $retypePassword = trim($_POST["retypePassword"]);

    $errors = [];
    
    if(empty($oldPassword)) {
        $errors[] = "La vecchia password è obbligatoria.";
    }

    if(empty($newPassword)) {
        $errors[] = "La nuova password è obbligatoria.";
    } elseif (strlen($newPassword) < 8) {
        $errors[] = "La password deve essere lunga almeno 8 caratteri.";
    }

    if (strlen($retypePassword) > 20) {
        $errors[] = "Lo username non può superare i 20 caratteri.";
    }

    if ($newPassword !== $retypePassword) {
        $errors[] = "Le password non corrispondono.";
    }

    if ($newPassword === $oldPassword) {
        $errors[] = "La password nuova coincide con quella attuale.";
    }

    if (!empty($errors)) {
        echo json_encode(["errors" => $errors]);
        exit();
    }

    // Controlliamo che l'utente non abbia immesso la password attuale sbagliata.
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $hashedPassword);
            mysqli_stmt_fetch($stmt);
        
            if (password_verify($oldPassword, $hashedPassword)){
                // Se la password inserita è corretta, facciamo l'update nel db
                $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    if ($updateStmt) {
                        mysqli_stmt_bind_param($updateStmt, "i", $user_id);
                        mysqli_stmt_execute($updateStmt);
                        mysqli_stmt_close($updateStmt);

                        echo json_encode(["success" => true, "message" => "Login effettuato con successo."]);
                    }
            } else {
                $errors[] = "Password attuale inserita non corretta.";
                echo json_encode(["error" => "La vecchia password non è corretta."]);
                exit();
            }
        } else {
            $errors[] = "Utente non trovato.";
            echo json_encode(["error" => "Errore durante l'aggiornamento della password."]);
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        $errors[] = "Errore del server. Riprovi più tardi.";
        echo json_encode(["error" => $errors]);
        exit();
    }
    
    mysqli_close($conn);

}
?>