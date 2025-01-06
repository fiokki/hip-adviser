<?php
    require_once 'db/config.php';
    require_once 'layout-elements/head.php';

    $search = trim($_POST["search"]);

    $query = "SELECT 
                'artist' AS type,
                artists.artist_name AS name,
                artists.photo AS img_url
            FROM 
                artists
            WHERE 
                artists.artist_name LIKE CONCAT('%', ?, '%')

            UNION

            SELECT 
                'album' AS type,
                albums.title AS name,
                albums.cover AS img_url
            FROM 
                albums
            LEFT JOIN 
                artists 
            ON 
                albums.artist_id = artists.id
            WHERE 
                artists.artist_name LIKE CONCAT('%', ?, '%')
                OR albums.title LIKE CONCAT('%', ?, '%')";

    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $search, $search, $search);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="albums-grid">';
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['type'] === 'album') {
                    echo '<div class="album-item">';
                    echo '<img src="' . $row['img_url'] . '" alt="' . $row['name'] . '">';
                    echo '<p>' . $row['name'] . '</p>';
                    echo '</div>';
                } elseif ($row['type'] === 'artist') {
                    echo '<div class="artist-item">';
                    echo '<img src="' . $row['img_url'] . '" alt="' . $row['name'] . '">';
                    echo '<p>' . $row['name'] . '</p>';
                    echo '</div>';
                }
            }
            echo '</div>';
        } else {
            echo '<div class="no-albums">Nessun album o artista trovato.</div>';
        }
        mysqli_stmt_close($stmt);
    }
    else {
        // Errore nella preparazione della query
        $errors[] = "Errore del server. Riprovi più tardi.";
        echo json_encode($errors);
        echo "<script>
        setTimeout(function() {
            window.location.href = '../login_form.php';
        }, 2000);
        </script>";
        exit();
    }
    mysqli_close($conn);
?>
