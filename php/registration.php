<?php
    require_once '../db/config.php';
    require_once 'checkemail.php';
    include_once '../layout-elements/head.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first = trim($_POST["firstname"]);
        $last = trim($_POST["lastname"]);
        $user = trim($_POST["username"]);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $newsletter = isset($_POST['newsletter']) ? 1 : 0;
        $pass = trim($_POST["pass"]);
        $conf = trim($_POST["confirm"]);
    }

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

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'indirizzo email &eacute mancante o non è valido.";
    } elseif (strlen($email) > 50) {
        $errors[] = "L'indirizzo email non puo' superare i 50 caratteri.";
    } elseif (isEmailRegistered($conn, $email)) {
        $errors[] = "L'indirizzo email &eacute già in uso.";
    }
    
    if (empty($pass)) {
        $errors[] = "La password &eacute obbligatoria.";
    } elseif (strlen($pass) < 8) {
        $errors[] = "La password deve contenere almeno 8 caratteri.";
    } elseif ($pass !== $conf) {
        $errors[] = "Le password non corrispondono.";
    }

    if (!empty($errors)) {
        echo "<p>" . implode("<br>", $errors) . "</p>
        <p>Sarai reindirizzato al modulo di registrazione tra 2 secondi.</p>
        <script>
                setTimeout(function() {
                    window.location.href = '../registration_form.php';
                }, 2000);
              </script>";
        exit();
    }

    if (strlen($user) > 20) {
        echo "<p>Lo username non puo' superare i 20 caratteri.</p>
        <script>
                setTimeout(function() {
                    window.location.href = '../login_form.php';
                }, 2000);
              </script>";
        exit();
    }

    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (first_name, last_name, user_name, email, password, newsletter) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssi", $first, $last, $user, $email, $hashedPassword, $newsletter);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Registrazione avvenuta con successo. Sarai reindirizzato alla pagina di login tra 2 secondi.</p>
            <script>
                    setTimeout(function() {
                        window.location.href = '../login_form.php';
                    }, 2000);
                  </script>";
            exit();
        } else {
            echo "<p>Errore durante la registrazione. Sarai reindirizzato al modulo di registrazione tra 2 secondi.</p>
            <script>
                    setTimeout(function() {
                        window.location.href = '../registration_form.php';
                    }, 2000);
                  </script>";
            exit();
        }

        mysqli_stmt_close($stmt);
    } else{
        echo "<p>Errore del server. Riprovi più tardi. Sarai reindirizzato al modulo di registrazione tra 2 secondi.</p>
        <script>
                setTimeout(function() {
                    window.location.href = '../registration_form.php';
                }, 2000);
              </script>";
        exit();
    }
    
    mysqli_close($conn);
?>

