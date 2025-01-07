<?php
    require_once 'db/config.php';
    require_once 'layout-elements/head.php';
    require_once 'layout-elements/header.php';


    $artist_id = $_GET['id'];
    $artist_query = "SELECT * FROM artists WHERE id = ?";
    $albums_query = "SELECT * FROM albums WHERE artist_id = ?";
    $artist_stmt = mysqli_prepare($conn, $artist_query);
    
    if ($artist_stmt){
        mysqli_stmt_bind_param($artist_stmt, 'i', $artist_id);
        mysqli_stmt_execute($artist_stmt);
        mysqli_stmt_store_result($artist_stmt);
        if (mysqli_stmt_num_rows($artist_stmt) > 0){
            mysqli_stmt_bind_result($artist_stmt, $artist_id, $artist_name, $photo, $bio);
            mysqli_stmt_fetch($artist_stmt);
            echo '<div class="artist_page">';
            echo '<h1>' . $artist_name . '</h1>';
            echo '<img src="' . $photo . '" alt="' . $artist_name . ' photo">';
            echo '<p>' . $bio . '</p>';
            echo '</div>';
        } else {
            echo '<div class="no-artist">Nessun artista trovato.</div>';
        }
        mysqli_stmt_close($artist_stmt);
    } else {
        // Errore nella preparazione della query
        $errors[] = "Errore del server. Riprovi più tardi.";
        echo json_encode($errors);
        echo "<script>
        setTimeout(function() {
            window.location.href = 'homepage.php';
        }, 2000);
        </script>";
        exit();
    }
    $albums_stmt = mysqli_prepare($conn, $albums_query);
    if ($albums_stmt){
        mysqli_stmt_bind_param($albums_stmt, 'i', $artist_id);
        mysqli_stmt_execute($albums_stmt);
        $result = mysqli_stmt_get_result($albums_stmt);
        if (mysqli_num_rows($result) > 0){
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
        } else {
            echo '<div class="no-albums">Nessun album trovato.</div>';
        }
        mysqli_stmt_close($albums_stmt);
    } else {
        // Errore nella preparazione della query
        $errors[] = "Errore del server. Riprovi più tardi.";
        echo json_encode($errors);
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
