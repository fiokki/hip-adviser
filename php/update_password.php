<?php
require_once '../db/config.php';
include_once '../layout-elements/head.php';
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]){
    $user_id = $_SESSION['user_id'];
} else {
    echo "<p>Si è verificato un errore. Sarai reindirizzato alla homepage tra 2 secondi.</p>
     <script>
            setTimeout(function() {
                window.location.href = '../homepage.php';
            }, 2000);
    </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = trim($_POST["oldPassword"]);
    $newPassword = trim($_POST["newPassword"]);
    $retypePassword = trim($_POST["retypePassword"]);

    $errors = [];
    
    if(empty($oldPassword)) {
        $errors[] = "La vecchia password &eacute obbligatoria.";
    }

    if(empty($newPassword)) {
        $errors[] = "La nuova password &eacute obbligatoria.";
    } elseif (strlen($newPassword) < 8) {
        $errors[] = "La password deve essere lunga almeno 8 caratteri.";
    }

    if (strlen($retypePassword) > 20) {
        $errors[] = "Lo username non puo' superare i 20 caratteri.";
    }

    if ($newPassword !== $retypePassword) {
        $errors[] = "Le password non corrispondono.";
    }

    if ($newPassword === $oldPassword) {
        $errors[] = "La password nuova coincide con quella attuale.";
    }

    if (!empty($errors)) {
        echo "<p>" . implode("<br>", $errors) . "</p>
        <p> Verrai reindirizzato alla pagina del tuo profilo tra 2 secondi. </p>
        <script>
                setTimeout(function() {
                    window.location.href = '../show_profile.php';
                }, 2000);
              </script>";
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    // Controlliamo che l'utente non abbia immesso la password attuale sbagliata.
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $oldHashedPassword);
            mysqli_stmt_fetch($stmt);
        
            if (password_verify($oldPassword, $oldHashedPassword)){
                // Se la password inserita è corretta, facciamo l'update nel db
                $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    if ($updateStmt) {
                        mysqli_stmt_bind_param($updateStmt, "si", $hashedPassword, $user_id);
                        if (mysqli_stmt_execute($updateStmt)) {
                            echo "<p>Aggiornamento della password avvenuto con successo. Sarai reindirizzato al tuo profilo tra 2 secondi.</p>
                            <script>
                                    setTimeout(function() {
                                        window.location.href = '../show_profile.php';
                                    }, 2000);
                                  </script>";
                            exit();
                        } else {
                            echo "<p>Errore durante l'aggiornamento della password. Sarai reindirizzato al tuo profilo tra 2 secondi.</p>
                            <script>
                                    setTimeout(function() {
                                        window.location.href = '../show_profile.php';
                                    }, 2000);
                                  </script>";
                        }
                        mysqli_stmt_close($stmt);
                    }
            } else {
                echo "<p>Password attuale inserita non corretta. Sarai reindirizzato al tuo profilo tra 2 secondi.</p>
                <script>
                        setTimeout(function() {
                            window.location.href = '../show_profile.php';
                        }, 2000);
                      </script>";
            }
        } else {
            echo "<p>Utente non trovato. Sarai reindirizzato al tuo profilo tra 2 secondi.</p>
            <script>
                    setTimeout(function() {
                        window.location.href = '../show_profile.php';
                    }, 2000);
                  </script>";
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<p>Errore del server. Riprovi più tardi. Sarai reindirizzato al tuo profilo tra 2 secondi.</p>
        <script>
                setTimeout(function() {
                    window.location.href = '../show_profile.php';
                }, 2000);
              </script>";
        exit();
    }
    
    mysqli_close($conn);

}
else{
    echo "<p>Si è verificato un errore. Sarai reindirizzato alla homepage tra 2 secondi.</p>
    <script>
        setTimeout(function() {
            window.location.href = '../homepage.php';
        }, 2000);
    </script>";
    exit();
}
?>
