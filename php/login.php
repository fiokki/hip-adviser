<?php
    require_once '../db/config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = json_decode(file_get_contents("php://input"), true);
        $email = isset($input["email"]) ? filter_var(trim($input["email"]), FILTER_SANITIZE_EMAIL) : "";
        $pass = isset($input["pass"]) ? trim($input["pass"]) : "";
    }

    $errors = [];
    
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'indirizzo email è mancante o non è valido.";
    }
    
    if (empty($pass)) {
        $errors[] = "La password è mancante.";
    }

    if (!empty($errors)) {
        echo json_encode(["errors" => $errors]);
        exit();
    }

    // Controllo delle credenziali
    $query = "SELECT id, password, role FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $userId, $hashedPassword, $userRole);
            mysqli_stmt_fetch($stmt);
        
            if (password_verify($password, $hashedPassword)) {
                // Avvio della sessione
                session_start();
                $_SESSION["user_id"] = $userId;
                $_SESSION["email"] = $email;
                $_SESSION["user_role"] = $userRole;

                // CONTINUA
            }
        }
    }
?>

