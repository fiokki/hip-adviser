<?php
require_once 'db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once 'layout-elements/head.php' ?>
        <title> Hip-Adviser | Ricerca Dettagliata </title>
    </head>
    <body>
        <?php include_once 'layout-elements/header.php'; ?>
        <?php
            $search = isset($_GET["search"]) ? trim($_GET["search"]) : '';

            $query = "SELECT
            'artist' AS type,
            artists.artist_name AS name,
            artists.photo AS img_url,
            CASE
                WHEN artists.artist_name LIKE CONCAT(?, '%') THEN 1
                ELSE 2
            END AS priority
        FROM
            artists
        WHERE
            artists.artist_name LIKE CONCAT('%', ?, '%')

        UNION

        SELECT
            'album' AS type,
            albums.title AS name,
            albums.cover AS img_url,
            CASE
                WHEN albums.title LIKE CONCAT(?, '%') THEN 1
                ELSE 2
            END AS priority
        FROM
            albums
        LEFT JOIN
            artists
        ON
            albums.artist_id = artists.id
        WHERE
            artists.artist_name LIKE CONCAT('%', ?, '%')
            OR albums.title LIKE CONCAT('%', ?, '%')

        ORDER BY
            priority, name";

            $stmt = mysqli_prepare($conn, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssss", $search, $search, $search, $search, $search);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="homepage-container">
                            <div class="welcome">
                                <h2>' . ($search !== '' ? 'Ecco i risultati per la ricerca: "' . htmlspecialchars($search) . '"' : 'Ecco tutti gli artisti e album disponibili') . '</h2>
                            </div>
                        <div class="albums-grid">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['type'] === 'album') {
                                echo '<div class="album-item">
                                        <img src="' . $row['img_url'] . '" alt="' . $row['name'] . '">
                                        <p>' . $row['name'] . '</p>
                                    </div>';
                            } elseif ($row['type'] === 'artist') {
                                echo '<div class="artist-item">
                                        <img src="' . $row['img_url'] . '" alt="' . $row['name'] . '">
                                        <p>' . $row['name'] . '</p>
                                    </div>';
                            }
                        }
                        echo '</div>
                        </div>';
                } else {
                    echo '<div class="no-albums">Nessun album o artista trovato.</div>';
                }
                mysqli_stmt_close($stmt);
            }
            else {
                // Errore nella preparazione della query
                echo "<p>Errore del server. Riprovi più tardi. Sarai reindirizzato all'homepage tra 2 secondi.</p>
                    <script>
                setTimeout(function() {
                    window.location.href = 'homepage.php';
                }, 2000);
                </script>";
                exit();
            }
            mysqli_close($conn);
        ?>

        <?php include_once 'layout-elements/footer.php' ?>
    </body>
</html>
