<?php
    require_once 'db/get_user_by_cookie.php';

    $title = 'Album non trovato'; // Default value
    $has_user_review = false;

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $album_id = $_GET['id'];
        $album_query = "SELECT albums.id, title, release_date, cover, link, artist_id, artist_name, photo FROM albums LEFT JOIN artists ON albums.artist_id=artists.id WHERE albums.id = ?";
        $reviews_query = "SELECT reviews.id, rating, comment, reviews.created_at, user_name, first_name, last_name FROM reviews LEFT JOIN users ON users.id = user_id WHERE album_id = ?";
        $avg_rating_query = "SELECT COUNT(*) as n_rec, AVG(rating) as avg FROM reviews WHERE album_id = ?";
        $album_stmt = mysqli_prepare($conn, $album_query);
        $reviews_stmt = mysqli_prepare($conn, $reviews_query);
        $avg_rating_stmt = mysqli_prepare($conn, $avg_rating_query);

        if ($album_stmt && $reviews_stmt && $avg_rating_stmt) {
            //Query per album
            mysqli_stmt_bind_param($album_stmt, 'i', $album_id);
            mysqli_stmt_execute($album_stmt);
            mysqli_stmt_bind_result($album_stmt, $album_id, $title, $release_date, $cover, $link, $artist_id, $artist_name, $artist_photo);
            mysqli_stmt_fetch($album_stmt);
            mysqli_stmt_close($album_stmt);

            //Query per reviews
            mysqli_stmt_bind_param($reviews_stmt, 'i', $album_id);
            mysqli_stmt_execute($reviews_stmt);
            $reviews_result = mysqli_stmt_get_result($reviews_stmt);
            mysqli_stmt_close($reviews_stmt);

            //Query per average review
            mysqli_stmt_bind_param($avg_rating_stmt, 'i', $album_id);
            mysqli_stmt_execute($avg_rating_stmt);
            mysqli_stmt_bind_result($avg_rating_stmt, $n_rec, $avg_rating);
            mysqli_stmt_fetch($avg_rating_stmt);
            mysqli_stmt_close($avg_rating_stmt);
        } else {
            echo "<p>Errore del server. Riprovi più tardi. Sarai reindirizzato all'homepage tra 2 secondi.</p>
                <script>
            setTimeout(function() {
                window.location.href = 'homepage.php';
            }, 2000);
            </script>";
            exit();
        }
    }

    // Verifichiamo se l'utente ha già lasciato una recensione (in questo caso può solo modificare quella che ha già immesso)
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        $user_review_query = "SELECT id, rating, comment FROM reviews WHERE album_id = ? AND user_id = ?";
        $user_review_stmt = mysqli_prepare($conn, $user_review_query);
        
        if ($user_review_stmt) {
            mysqli_stmt_bind_param($user_review_stmt, 'ii', $album_id, $user_id);
            mysqli_stmt_execute($user_review_stmt);
            mysqli_stmt_bind_result($user_review_stmt, $review_id, $user_rating, $user_comment);
            
            if (mysqli_stmt_fetch($user_review_stmt)) {
                // L'utente ha già lasciato una recensione
                $has_user_review = true;
            }
            mysqli_stmt_close($user_review_stmt);
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
                echo "<p>Album non trovato. Sarai reindirizzato alla homepage tra 2 secondi.</p>
                <script>
                        setTimeout(function() {
                            window.location.href = 'homepage.php';
                        }, 2000);
                      </script>";
                exit();
            } else {
                echo '<div class="flex-container">
                        <div class="album-container">
                            <span class="album-info">
                            <img src="' . htmlspecialchars($cover) . '" alt="' . htmlspecialchars($title) . ' cover">
                            <h1>' . htmlspecialchars($title) . '</h1>
                            <div class="artist-info">
                                <a href="artist.php?id='. $artist_id . '">
                                    <img src="' . htmlspecialchars($artist_photo) . '" alt="' . htmlspecialchars($artist_name) . '">
                                    <h3>' .   htmlspecialchars($artist_name) . '</h3>
                                </a>
                            </div>
                            <h3> Rilasciato il: ' . htmlspecialchars(formatDate($release_date)) . '</h3>
                            </span>
                            <span class="avg-ratings">
                                <iframe style="border-radius:12px" src="' . htmlspecialchars($link) . '" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                                <h2> Valutazioni dei nostri utenti:' . round($avg_rating, 1) . '/5 </h2>
                                <h3> Basato su ' . $n_rec . ' valutazioni.</h3>
                            </span>
                        </div>';

                        
                    $review_form = '<div class="review-form">';
                    if($has_user_review){
                        $review_form .= '<h2> Aggiorna la tua recensione </h2>
                                        <form class="review" id="review">
                                            <input type="hidden" name="album_id" value="' . htmlspecialchars($album_id) . '" />
                                            <div class="rating">';
                    for ($i = 5; $i >= 1; $i--) {
                        $checked = ($user_rating == $i) ? 'checked' : '';
                        $review_form .= '<input type="radio" id="star' . $i . '" name="rating" value="' . $i . '" ' . $checked . '>
                                        <label for="star' . $i . '">&#9733;</label>';
                        }
                        $review_form .= '</div>
                                            <div class="comment">
                                                <label for="comment">Dicci cosa ne pensi:</label><br>
                                                <textarea id="comment" name="comment">' . htmlspecialchars($user_comment) . '</textarea>
                                            </div>
                                            <input type="submit" class="submit-btn" value="Invia recensione">
                                        </form>
                                    </div>';
                    } else {
                        $review_form .= '<h2>Lascia la tua recensione</h2>
                                        <form class="review" id="review">
                                            <input type="hidden" name="album_id" value="' . htmlspecialchars($album_id) . '" />
                                            <div class="rating">
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
                                            <input type="submit" class="submit-btn" value="Invia recensione">
                                        </form>
                                        </div>';
                    }
                echo $review_form;
                echo '</div>';
                if (mysqli_num_rows($reviews_result) === 0){
                    echo '<div class="no-reviews"> Non ci sono valutazioni per questo album. Potresti essere il primo a valutarlo! </div>';
                }
                else {
                    echo '<div class="reviews-container">
                        <h2 class="reviews-title"> Le valutazioni dei nostri utenti: </h2>
                        <div class="review-grid">';
                            while ($row = mysqli_fetch_assoc($reviews_result)) {
                                $displayed_name = $row['user_name'] != null ? $row['user_name'] : $row['first_name'] . ' ' . $row['last_name'];
                                echo '<div class="review-item">
                                        <p><strong>Nome:</strong> ' . htmlspecialchars($displayed_name) . '</p>
                                        <p><strong>Voto:</strong> ' . htmlspecialchars($row['rating']) . '/5 </p>
                                        <p><strong>Data:</strong> ' . htmlspecialchars($row['created_at']) . '</p>
                                        <p><strong>Commento:</strong> ' . htmlspecialchars($row['comment']) . '</p>
                                    </div>';
                            }
                        echo '</div>';
                    echo '</div>';
                }
            }
            mysqli_close($conn);
            require_once 'layout-elements/footer.php';


            function formatDate($date) {
                // Localizzazione italiana per la data
                setlocale(LC_TIME, 'it_IT.UTF-8', 'it_IT', 'it', 'ita');
                
                $timestamp = date_create_from_format('Y-m-d', $date);
                if ($timestamp) {
                    // Formatta la data nel formato '13 Dicembre 2024'
                    return strftime('%d %B %Y', $timestamp->getTimestamp());
                } else {
                    return "Formato non valido";
                }
            }
        ?>

        <!-- Script per mandare la recensione -->
        <script>
        document.getElementById('review').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            fetch('php/submit_review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log(response);
                return response.json();
            })
            .then(data => {
                console.log(data);
                alert(data.message);
                if (data.status === 'success') {
                    location.reload();
                }
            })
            .catch(error => console.error('Errore:', error));
                    });
        </script>
    </body>
</html>