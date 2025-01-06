<?php
    session_start();
    include_once '../layout-elements/head.php';

    if (!isset($_SESSION["user_id"])) {
        echo "<p>Non sei loggato! Sarai reindirizzato alla homepage tra 2 secondi.</p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../homepage.php';
                }, 2000);
              </script>";
        exit();
    }

    $user_id = $_SESSION["user_id"];
    // Svuotiamo e distruggiamo la sessione attuale
    session_unset();
    session_destroy();

    // Se esiste impostiamo il cookie del remember me come scaduto e lo eliminiamo nel db
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 172800, '/');
    
        require_once '../db/config.php';
        $query = "UPDATE users SET cookie_id = NULL, cookie_expiry = NULL WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            echo "<p>Errore nel database. Sarai reindirizzato alla homepage tra 2 secondi.</p>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '../homepage.php';
                    }, 2000);
                  </script>";
        }
        
        mysqli_close($conn);
    }

    // Reindirizza l'utente alla homepage
    header("Location: ../homepage.php");
    exit();
?>
