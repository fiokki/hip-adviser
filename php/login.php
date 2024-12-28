<?php
    require_once '../db/config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = json_decode(file_get_contents("php://input"), true); // Decodifica dei dati JSON inviati dal frontend
        $email = isset($input["email"]) ? filter_var(trim($input["email"]), FILTER_SANITIZE_EMAIL) : "";
        $pass = isset($input["pass"]) ? trim($input["pass"]) : "";
        $rememberMe = isset($input["rememberMe"]) ? $input["rememberMe"] : false;
    }

    $errors = [];
    
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'indirizzo email è mancante o non è valido.";
    }
    
    if (empty($pass)) {
        $errors[] = "La password è mancante.";
    }

    if (!empty($errors)) {
        echo json_encode(["error" => $errors]);
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
                echo json_encode(["success" => true, "message" => "Login effettuato con successo."]);
            } else {
                // Password errata
                $errors[] = "La password è errata.";
                echo json_encode(["message" => $errors]);
                exit();
            }
        } else {
            // Utente non trovato
            $errors[] = "La email inserita non è corretta.";
            echo json_encode(["message" => $errors]);
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        // Errore nella preparazione della query
        $errors[] = "Errore del server. Riprovi più tardi.";
        echo json_encode(["error" => $errors]);
        exit();
    }

    mysqli_close($conn);
?>
