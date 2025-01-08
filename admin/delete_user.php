<?php
require_once '../db/get_user_by_cookie.php';
include_once '../layout-elements/head.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../layout-elements/no_permiss.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = intval($_GET['id']);
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    if (mysqli_stmt_execute($stmt)) {
        // Redirezione alla pagina di gestione utenti con un messaggio di successo
        echo "<p>Utente eliminato con successo. Sarai reindirizzato alla pagina di gestione utenti tra 2 secondi.</p>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'manage_users.php';
            }, 2000);
        </script>";
    } else {
        // Redirezione con un messaggio di errore in caso di fallimento
        echo "<p>Errore durante l'eliminazione dell'utente. Sarai reindirizzato alla pagina di gestione utenti tra 2 secondi.</p>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'manage_users.php';
            }, 2000);
        </script>";
    }
    mysqli_stmt_close($stmt);
} else {
    // Redirezione se l'ID non è valido
    echo "<p>ID utente non valido. Sarai reindirizzato alla pagina di gestione utenti tra 2 secondi.</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'manage_users.php';
        }, 2000);
    </script>";
}

mysqli_close($conn);
?>
