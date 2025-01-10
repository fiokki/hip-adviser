<?php
require_once '../db/get_user_by_cookie.php';
include_once '../layout-elements/head.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../layout-elements/no_permiss.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $reviewId = intval($_GET['id']);
    
    $stmt = mysqli_prepare($conn, "DELETE FROM reviews WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $reviewId);
    
    if (mysqli_stmt_execute($stmt)) {
        // Se la recensione è stata eliminata, mostra un messaggio di successo e reindirizza alla pagina di gestione recensioni
        echo "<p>Recensione eliminata con successo. Sarai reindirizzato alla pagina di gestione recensioni tra 2 secondi.</p>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'manage_posts.php';
            }, 2000);
        </script>";
    } else {
        // Se c'è un errore, mostra un messaggio di errore e reindirizza alla pagina di gestione recensioni
        echo "<p>Errore durante l'eliminazione della recensione. Sarai reindirizzato alla pagina di gestione recensioni tra 2 secondi.</p>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'manage_posts.php';
            }, 2000);
        </script>";
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Se l'ID non è valido, reindirizza con un messaggio di errore
    echo "<p>ID recensione non valido. Sarai reindirizzato alla pagina di gestione recensioni tra 2 secondi.</p>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'manage_posts.php';
        }, 2000);
    </script>";
}

mysqli_close($conn);
?>
