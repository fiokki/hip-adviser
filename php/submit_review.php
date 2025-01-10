<?php
require_once '../db/config.php';
session_start();

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
    $user_id = $_SESSION['user_id'];
} else {
    echo json_encode(['status' => 'error', 'message' => 'Sessione non valida.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $album_id = trim($_POST["album_id"]);
    $rating = trim($_POST["rating"]);
    $comment = trim($_POST["comment"]);

    $errors = [];

    if (empty($album_id)) {
        $errors[] = "L'album è obbligatorio.";
    }
    if (empty($rating) || !in_array($rating, [1, 2, 3, 4, 5])) {
        $errors[] = "La valutazione deve essere tra 1 e 5.";
    }
    if (strlen($comment) > 500) {
        $errors[] = "Il commento non può superare i 500 caratteri.";
    }

    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => implode("<br>", $errors)]);
        exit();
    }

    // Verifica se l'utente ha già lasciato una recensione per lo stesso album
    $query_check = "SELECT id FROM reviews WHERE user_id = ? AND album_id = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $album_id);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        // Se la recensione esiste già, esegui un update
        $query_update = "UPDATE reviews SET rating = ?, comment = ? WHERE user_id = ? AND album_id = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);

        if ($stmt_update) {
            mysqli_stmt_bind_param($stmt_update, "isis", $rating, $comment, $user_id, $album_id);

            if (mysqli_stmt_execute($stmt_update)) {
                echo json_encode(['status' => 'success', 'message' => 'Recensione aggiornata con successo!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'aggiornamento della recensione.']);
            }

            mysqli_stmt_close($stmt_update);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore nella preparazione della query di aggiornamento.']);
        }
    } else {
        // Se la recensione non esiste, inserisci una nuova recensione
        $query_insert = "INSERT INTO reviews (user_id, album_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);

        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, "iiis", $user_id, $album_id, $rating, $comment);

            if (mysqli_stmt_execute($stmt_insert)) {
                echo json_encode(['status' => 'success', 'message' => 'Recensione inviata con successo!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'invio della recensione.']);
            }

            mysqli_stmt_close($stmt_insert);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore nella preparazione della query di inserimento.']);
        }
    }

    mysqli_stmt_close($stmt_check);
    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metodo non valido.']);
    exit();
}
?>
