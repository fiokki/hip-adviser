<?php
require_once 'db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once 'layout-elements/head.php' ?>
        <title> Hip-Adviser </title>
        </head>
        <body>
                <?php 
                include_once 'layout-elements/header.php';
                include_once 'layout-elements/navbar.php';
                ?>

                <div class="filter-bar">
                                <button id="filterButton">
                                        <img src="images/filter-icon.png" alt="Filtra" />
                                        <span class="filter-label">Ordina per:</span>
                                </button>

                                <div id="filter-menu" class="filter-menu">
                                        <ul>
                                                <?php
                                                // I filtri cambiano in base se stiamo visualizzando gli album o gli artisti.
                                                $page = isset($_GET['page']) ? $_GET['page'] : 'albums';
                                                if ($page === 'albums') {
                                                        echo '<li><a href="#" onclick="applyFilter(\'release_date\')">Data di Rilascio</a></li>';
                                                        echo '<li><a href="#" onclick="applyFilter(\'alphabetical\')">Ordine alfabetico</a></li>';
                                                        echo '<li><a href="#" onclick="applyFilter(\'top_rated\')">Numero di recensioni</a></li>';
                                                        echo '<li><a href="#" onclick="applyFilter(\'highest_rated\')">Media voti</a></li>';
                                                } elseif ($page === 'artists') {
                                                        echo '<li><a href="#" onclick="applyFilter(\'most_albums\')">Artista con più album</a></li>';
                                                        echo '<li><a href="#" onclick="applyFilter(\'alphabetical_artists\')">Ordine alfabetico</a></li>';
                                                }
                                                ?>
                                        </ul>
                                </div>
                </div>

                <div class="homepage-container">
                        <div class="welcome">
                        <?php
                                if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
                                        // Messaggio per utenti loggati
                                        if ($page === 'artists') {
                                        echo 'Ciao ' . $_SESSION["user_id"] . ', dai un\'occhiata agli artisti del nostro rooster!';
                                        } else {
                                        echo 'Ciao ' . $_SESSION["user_id"] . ', inizia a recensire i tuoi album preferiti!';
                                        }
                                } else {
                                        // Messaggio per utenti non loggati
                                        if ($page === 'artists') {
                                        echo 'Unisciti alla nostra community di adviser, per rimanere sempre aggiornato sui tuoi artisti preferiti!';
                                        } else {
                                        echo 'Unisciti alla nostra community di adviser, ed inizia a recensire i tuoi album preferiti!';
                                        }
                                }
                                ?>
                        </div>
        
                        <?php
                        require_once 'db/config.php';

                        // Di default vogliamo visualizzare gli album dal più recente. Se invece è applicato un filtro, visualizziamo in base a ciò che vuole l'utente.
                        // Abbiamo già ricavato il valore di 'page', quindi ricaviamo 'filter' e 'order', se sono impostati
                        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'release_date';
                        $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
                
                        // Crea la query dinamica in base al filtro e all'ordinamento
                        if ($page === 'albums'){
                                if ($filter === 'release_date') {
                                $sql = "SELECT * FROM albums ORDER BY release_date $order LIMIT 200";
                                } elseif ($filter === 'alphabetical') {
                                $sql = "SELECT * FROM albums ORDER BY title $order LIMIT 200";
                                } elseif ($filter === 'top_rated') {
                                $sql = "SELECT albums.*, COUNT(reviews.id) AS review_count
                                                FROM albums
                                                LEFT JOIN reviews ON albums.id = reviews.album_id
                                                GROUP BY albums.id
                                                ORDER BY review_count $order LIMIT 200";
                                } elseif ($filter === 'highest_rated') {
                                $sql = "SELECT albums.*, AVG(reviews.rating) AS avg_rating
                                                FROM albums
                                                LEFT JOIN reviews ON albums.id = reviews.album_id
                                                GROUP BY albums.id
                                                ORDER BY avg_rating $order LIMIT 200";
                                }
                        }
                        elseif ($page === 'artists'){
                                if ($filter === 'most_albums') {
                                        $sql = "SELECT artists.*, artists.artist_name, COUNT(albums.id) AS album_count
                                                FROM artists
                                                LEFT JOIN albums ON artists.id = albums.artist_id
                                                GROUP BY artists.id
                                                ORDER BY album_count $order LIMIT 200";
                                } elseif ($filter === 'alphabetical_artists') {
                                        $sql = "SELECT * FROM artists ORDER BY artist_name $order LIMIT 200";
                                } else {
                                        //Se non ci sono filtri applicati in artists, li mostriamo in ordine alfabetico di default
                                        $sql = "SELECT * FROM artists ORDER BY artist_name ASC LIMIT 200";
                                }
                        }

                        $result = mysqli_query($conn, $sql);

                        // Se la query ritorna delle rows, le mandiamo in output sottoforma di griglia
                        if (mysqli_num_rows($result) > 0) {
                                echo '<div class="' . $page . '-grid">';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($page === 'albums') {
                                        echo '<div class="album-item">';
                                        echo '<img src="' . $row['cover'] . '" alt="' . $row['title'] . '">';
                                        echo '<p>' . $row['title'] . '</p>';
                                        echo '</div>';

                                    } elseif ($page === 'artists') {
                                        echo '<div class="artist-item">';
                                        echo '<img src="' . $row['photo'] . '" alt="' . $row['artist_name'] . '">';
                                        echo '<p>' . $row['artist_name'] . '</p>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            } else {
                                echo '<div class="no-' . $page . '">Nessun ' . ($page === 'albums' ? 'album' : 'artista') . ' trovato.</div>';
                        }

                        mysqli_close($conn);
                        ?>
                </div>

                <?php include_once 'layout-elements/footer.php' ?>
                <script src="js/filters.js"></script>
        </body>
</html>
