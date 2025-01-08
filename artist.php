<?php
require_once 'db/get_user_by_cookie.php';

$artist_name = 'Artista non trovato'; // Default value

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $artist_id = $_GET['id'];
    $artist_query = "SELECT * FROM artists WHERE id = ?";
    $artist_stmt = mysqli_prepare($conn, $artist_query);
    
    if ($artist_stmt) {
        mysqli_stmt_bind_param($artist_stmt, 'i', $artist_id);
        mysqli_stmt_execute($artist_stmt);
        mysqli_stmt_store_result($artist_stmt);

        if (mysqli_stmt_num_rows($artist_stmt) > 0) {
            mysqli_stmt_bind_result($artist_stmt, $artist_id, $artist_name, $photo, $bio);
            mysqli_stmt_fetch($artist_stmt);
        }
        mysqli_stmt_close($artist_stmt);
    } else {
        echo "<p>Errore del server. Riprovi più tardi. Sarai reindirizzato all'homepage tra 2 secondi.</p>";
        echo "<script>
        setTimeout(function() {
            window.location.href = 'homepage.php';
        }, 2000);
        </script>";
        exit();
    }
}
?>
<html lang="it">
<?php include_once 'layout-elements/head.php' ?>
    <title>Hip-Adviser | <?php echo htmlspecialchars($artist_name); ?></title>
</head>
<body>
    <?php include_once 'layout-elements/header.php' ?>

    <?php
    if ($artist_name === 'Artista non trovato') {
        echo '<div class="no-artists">Nessun artista trovato.</div>';
    } else {
        echo '<div class="artist-container">';
            echo '<h1>' . htmlspecialchars($artist_name) . '</h1>';
            echo '<img src="' . htmlspecialchars($photo) . '" alt="' . htmlspecialchars($artist_name) . ' photo">';
            echo '<div class="artist-bio-container">';
                echo '<h2>Biografia</h2>';
                echo '<p>' . htmlspecialchars($bio) . '</p>';
            echo '</div>';
        echo '</div>';
    }

    $albums_query = "SELECT * FROM albums WHERE artist_id = ?";
    $albums_stmt = mysqli_prepare($conn, $albums_query);
    if ($albums_stmt){
        mysqli_stmt_bind_param($albums_stmt, 'i', $artist_id);
        mysqli_stmt_execute($albums_stmt);
        $result = mysqli_stmt_get_result($albums_stmt);
        if (mysqli_num_rows($result) > 0){
            echo '<div class="albums-container">';
            echo '<h2>Album rilasciati:</h2>';
                echo '<div class="albums-grid">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="album-item">';
                            echo '<a href="album.php?id=' . $row['id'] . '">';
                            echo '<img src="' . $row['cover'] . '" alt="' . $row['title'] . '">';
                            echo '<p>' . $row['title'] . '</p>';
                            echo '</a>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="no-albums">Nessun album trovato.</div>';
        }
        mysqli_stmt_close($albums_stmt);
    } else {
        echo "<p>Errore del server. Riprovi più tardi. Sarai reindirizzato all'homepage tra 2 secondi.</p>";
        echo "<script>
        setTimeout(function() {
            window.location.href = 'homepage.php';
        }, 2000);
        </script>";
        exit();
    }

    mysqli_close($conn);
    require_once 'layout-elements/footer.php'
?>
</body>
</html>


