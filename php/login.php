<?php
    require_once '../db/config.php';
    include_once '../layout-elements/head.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $pass = trim($_POST["pass"]);
        $rememberMe = isset($_POST["rememberMe"]) ? $_POST["rememberMe"] : false;
    }

    $errors = [];
    
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'indirizzo email &eacute mancante o non &eacute valido.";
    }
    
    if (empty($pass)) {
        $errors[] = "La password &eacute mancante.";
    }

    if (!empty($errors)) {
        echo "<p>" . implode("<br>", $errors) . "</p>";
        echo "<p>Sarai reindirizzato al modulo di login tra 2 secondi.</p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../login_form.php';
                }, 2000);
              </script>";
        exit();
    }

    // Controllo delle credenziali
    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $userId, $hashedPassword);
            mysqli_stmt_fetch($stmt);
        
            if (password_verify($pass, $hashedPassword)) {
                // Avvio della sessione
                session_start();
                $_SESSION["user_id"] = $userId;

                // Gestione "remember me"
                if ($rememberMe) {
                    // Crea un token univoco per "remember me"
                    $token = bin2hex(random_bytes(32)); // Genera un token sicuro
                    $expiry = time() + (60 * 60 * 24 * 30); // Imposta una scadenza di 30 giorni

                    // Salva il token nel database associato all'utente
                    $updateQuery = "UPDATE users SET cookie_id = ?, cookie_expiry = ? WHERE id = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    if ($updateStmt) {
                        mysqli_stmt_bind_param($updateStmt, "ssi", $token, $expiry, $userId);
                        mysqli_stmt_execute($updateStmt);
                        mysqli_stmt_close($updateStmt);

                        // Imposta il cookie con il token e la data di scadenza
                        setcookie("remember_me", $token, $expiry, "/", "");
                    }
                }

                // Successo, invia una risposta positiva
                    echo "<p>Login avvenuto con successo. Sarai reindirizzato all'homepage tra 2 secondi.</p>";
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = '../homepage.php';
                            }, 2000);
                        </script>";
                    exit();
                } else {
                // Password errata
                    echo "<p>La password &eacute errata. Sarai reindirizzato al modulo di login tra 2 secondi.</p>";
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = '../login_form.php';
                        }, 2000);
                    </script>";
                    exit();
            }
        } else {
            // Utente non trovato
            echo "<p>La email inserita non &eacute corretta. Sarai reindirizzato al modulo di login tra 2 secondi.</p>";
            echo "<script>
            setTimeout(function() {
                window.location.href = '../login_form.php';
            }, 2000);
            </script>";
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        // Errore nella preparazione della query
        echo "<p>Errore del server. Riprovi più tardi. Sarai reindirizzato al modulo di login tra 2 secondi.</p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../login_form.php';
                }, 2000);
              </script>";
        exit();
    }

    mysqli_close($conn);
?>
