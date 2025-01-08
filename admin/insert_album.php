<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once '../layout-elements/head.php' ?>
        <title> Hip-Adviser | Inserimento Album </title>
    </head>
    <body>
        <?php
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: ../layout-elements/no_permiss.php");
        }

        include_once '../layout-elements/header.php';
        ?>

        <form action="insert_album_backend.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <h2>Inserisci album</h2>
            <h3>L'inserimento di un album comporterà l'invio di una mail a tutti gli utenti iscritti alla newsletter</h3>

            <label for="title">Titolo Album:</label>
            <input type="text" name="title" id="title" required><br><br>

            <label for="artist_id">Artista:</label>
            <select name="artist_id" id="artist_id" required>
                <?php
                $artists = mysqli_query($conn, "SELECT id, artist_name FROM artists ORDER BY artist_name ASC");
                while ($artist = mysqli_fetch_assoc($artists)) {
                    echo "<option value='{$artist['id']}'>{$artist['artist_name']}</option>";
                }
                ?>
            </select><br><br>

            <label for="release_date">Data di uscita:</label>
            <input type="date" name="release_date" id="release_date" required><br><br>

            <label for="cover">Cover:</label>
            <input type="url" name="cover" id="cover" required><br><br>

            <label for="link">Link Album:</label>
            <input type="url" name="link" id="link" required><br><br>

            <input type="submit" name="submit" value="Inserisci Album!">
            </div>
        </form>
        <?php require_once '../layout-elements/footer.php' ?>
    </body>
</html>