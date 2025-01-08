<?php
require_once '../db/get_user_by_cookie.php';

// Funzione per eseguire una query semplice generica, e restituire il risultato
function getStat($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Statistiche principali
$users_count_result = getStat("SELECT COUNT(id) AS total_users FROM users");
$users_count = $users_count_result['total_users'];

$artists_count_result = getStat("SELECT COUNT(id) AS total_artists FROM artists");
$artists_count = $artists_count_result['total_artists'];

$albums_count_result = getStat("SELECT COUNT(id) AS total_albums FROM albums");
$albums_count = $albums_count_result['total_albums'];

$reviews_count_result = getStat("SELECT COUNT(id) AS total_reviews FROM reviews");
$reviews_count = $reviews_count_result['total_reviews'];

// TOP 3
// Utenti che hanno lasciato recensioni
$top_users_result = mysqli_query($conn, "SELECT u.first_name, u.last_name, COUNT(r.id) AS review_count
                                           FROM users u
                                           JOIN reviews r ON u.id = r.user_id
                                           GROUP BY u.id
                                           ORDER BY review_count DESC
                                           LIMIT 3");

// Album più piaciuti (con le recensioni migliori)
$top_albums_result = mysqli_query($conn, "SELECT a.title, AVG(r.rating) AS avg_rating
                                            FROM albums a
                                            JOIN reviews r ON a.id = r.album_id
                                            GROUP BY a.id
                                            ORDER BY avg_rating DESC
                                            LIMIT 3");

// Artisti più piaciuti (media delle recensioni dei loro album)
$top_artists_result = mysqli_query($conn, "SELECT ar.artist_name, AVG(r.rating) AS avg_artist_rating
                                              FROM artists ar
                                              JOIN albums a ON ar.id = a.artist_id
                                              JOIN reviews r ON a.id = r.album_id
                                              GROUP BY ar.id
                                              ORDER BY avg_artist_rating DESC
                                              LIMIT 3");

?>

<html lang="it">
    <?php include_once '../layout-elements/head.php'; ?>
    <title> Hip-Adviser | Statistiche</title>
</head>
<body>
    <?php
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: ../layout-elements/no_permiss.php");
        }
    ?>
    
    <?php include_once '../layout-elements/header.php'; ?>
    <div class="statistics-container">
        <h1>Statistiche</h1>

        <!-- Statistiche principali -->
        <div class="statistics">
            <h2>Statistiche Generali</h2>
            <ul>
                <li>Utenti Registrati: <?php echo $users_count; ?></li>
                <li>Artisti nel Rooster: <?php echo $artists_count; ?></li>
                <li>Album Presenti: <?php echo $albums_count; ?></li>
                <li>Recensioni Inserite: <?php echo $reviews_count; ?></li>
            </ul>
        </div>

        <!-- Top 3  -->
        <div class="top-3">
            <h2>Top 3 Utenti con più recensioni</h2>
            <ul>
                <?php while ($user = mysqli_fetch_assoc($top_users_result)) { ?>
                    <li><?php echo $user['first_name'] . ' ' . $user['last_name'] . ' - Recensioni: ' . $user['review_count']; ?></li>
                <?php } ?>
            </ul>
        </div>

        <div class="top-3">
            <h2>Top 3 Album più piaciuti</h2>
            <ul>
                <?php while ($album = mysqli_fetch_assoc($top_albums_result)) { ?>
                    <li><?php echo $album['title'] . ' - Media Voto: ' . round($album['avg_rating'], 2); ?></li>
                <?php } ?>
            </ul>
        </div>

        <div class="top-3">
            <h2>Top 3 Artisti più piaciuti</h2>
            <ul>
                <?php while ($artist = mysqli_fetch_assoc($top_artists_result)) { ?>
                    <li><?php echo $artist['artist_name'] . ' - Media Voto: ' . round($artist['avg_artist_rating'], 2); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <?php include_once '../layout-elements/footer.php'; ?>
</body>
</html>
