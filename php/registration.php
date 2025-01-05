<?php
    require_once '../db/config.php';
    require_once 'checkemail.php';

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
        $errors[] = "Il nome utente non può superare i 20 caratteri.";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'indirizzo email è mancante o non è valido.";
    } elseif (strlen($email) > 50) {
        $errors[] = "L'indirizzo email non può superare i 50 caratteri.";
    }
    
    if (empty($pass)) {
        $errors[] = "La password è obbligatoria.";
    } elseif (strlen($pass) < 8) {
        $errors[] = "La password deve contenere almeno 8 caratteri.";
    }
    if ($pass !== $conf) {
        $errors[] = "Le password non corrispondono.";
    }

    if (isEmailRegistered($conn, $email)) {
        $errors[] = "L'indirizzo email è già in uso.";
    }

    if (!empty($errors)) {
        echo json_encode(["errors" => $errors]);
        exit();
    }

    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (first_name, last_name, user_name, email, password, newsletter) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssi", $first, $last, $user, $email, $hashedPassword, $newsletter);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('Registrazione avvenuta con successo!');
                window.location.href = '../login_form.php';
            </script>";
            exit();
        } else {
            echo "Errore durante la registrazione: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else{
        echo "Errore nella preparazione della query: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
?>

