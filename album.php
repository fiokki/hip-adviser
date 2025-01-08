<?php
    require_once 'db/get_user_by_cookie.php';

    $title = 'Album non trovato'; // Default value
    
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $album_id = $_GET['id'];
        $album_query = "SELECT albums.id, title, release_date, cover, link, artist_id, artist_name FROM albums LEFT JOIN artists ON albums.artist_id=artists.id WHERE albums.id = ?";
        $reviews_query = "SELECT reviews.id, rating, comment, reviews.created_at, user_name, first_name, last_name FROM reviews LEFT JOIN users ON users.id = user_id WHERE album_id = ?";
        $album_stmt = mysqli_prepare($conn, $album_query);
        $reviews_stmt = mysqli_prepare($conn, $reviews_query);
        
        if ($album_stmt && $reviews_stmt) {
            //Query per album
            mysqli_stmt_bind_param($album_stmt, 'i', $album_id);
            mysqli_stmt_execute($album_stmt);
            mysqli_stmt_store_result($album_stmt);
    
            if (mysqli_stmt_num_rows($album_stmt) > 0) {
                mysqli_stmt_bind_result($album_stmt, $album_id, $title, $release_date, $cover, $link, $artist_id, $artist_name);
                mysqli_stmt_fetch($album_stmt);
            }
            mysqli_stmt_close($album_stmt);
            //Query per reviews
            mysqli_stmt_bind_param($reviews_stmt, 'i', $album_id);
            mysqli_stmt_execute($reviews_stmt);
            $reviews_result = mysqli_stmt_get_result($reviews_stmt);

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
        <title>Hip-Adviser | <?php echo htmlspecialchars($title); ?></title>
    </head>
    <body>
        <?php 
            include_once 'layout-elements/header.php';
            if ($title === 'Album non trovato') {
                echo '<div class="no-albums">Nessun album trovato.</div>';
            } else {
                echo '<div class="album-container">';
                echo '<img src="' . htmlspecialchars($cover) . '" alt="' . htmlspecialchars($title) . ' cover">';
                echo '<h1>' . htmlspecialchars($title) . '</h1>';
                echo '<h3> Rilasciato il: ' . htmlspecialchars(formatDate($release_date)) . '</h3>';
                echo '</div>';
                // review form
                echo '<div class="review-form">
                        <h2>Lascia la tua recensione</h2>
                        <form id="review">
                            <div class="rating">
                                <!-- Notice that the stars are in reverse order -->
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5">&#9733;</label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4">&#9733;</label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3">&#9733;</label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2">&#9733;</label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1">&#9733;</label>
                            </div>
                            <div class="comment">
                                <label for="comment">Dicci cosa ne pensi:</label><br>
                                <textarea id="comment" name="comment"></textarea>
                            </div>
                            <button type="submit" class="submit-btn">Invia recensione</button>
                        </form>
                        </div>';
                if (mysqli_num_rows($reviews_result) === 0){
                    echo '<div class="no-reviews"> Non ci sono valutazioni per questo album; Potresti essere il primo a valutarlo! </div>';
                }
                else {
                    echo '<div class="reviews-container">
                        <h2> Le valutazioni dei nostri utenti: </h2>';
                    while ($row = mysqli_fetch_assoc($reviews_result)){
                        $displayed_name = $row['user_name'] != null ? $row['user_name'] : $row['first_name'] . ' ' . $row['last_name'];
                        echo '<div class="review-item">';
                        echo '<h4>' . $displayed_name . '<h4>';
                        echo '<p>' . $row['created_at'] . '</p>';
                        echo '<p>' . $row['rating'] . '/5 </p>';
                        echo '<p>' . $row['comment'] . '</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            mysqli_close($conn);
            require_once 'layout-elements/footer.php';


            function formatDate($date) {
                $timestamp = date_create_from_format('Y-m-d', $date);
                if ($timestamp) {
                    return $timestamp = date_format($timestamp, 'F j, Y');
                } else {
                    return "Formato non valido";
                }
            }
        ?>
    </body>
</html>