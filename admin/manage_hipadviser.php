<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once '../layout-elements/head.php' ?>
        <title> Hip-Adviser | Gestione Sito </title>
    </head>
    <body>
        <?php
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: ../layout-elements/no_permiss.php");
        }

        include_once '../layout-elements/header.php';
        ?>
        <div class="admin-dashboard">
            <h1>Area Amministrativa</h1>
            
            <div class="dashboard-actions">
                <h2>Seleziona una sezione de gestire</h2>
                <button onclick="window.location.href='manage_albums.php'">Gestione Album</button>
                <button onclick="window.location.href='manage_artists.php'">Gestione Artisti</button>
            </div>
        </div>
        <?php require_once '../layout-elements/footer.php' ?>
    </body>
</html>
