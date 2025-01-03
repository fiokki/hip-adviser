<?php
require_once 'db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once 'head.php' ?>
        <title> Hip-Adviser </title>
        </head>
        <body>
                <?php include_once 'header.php' ?>
                <!-- Includere navbar -->

                <div class="filter-bar">
                                <button id="filterButton">
                                        <img src="images/filter-icon.png" alt="Filtra album" />
                                        <span class="filter-label">Ordina per:</span>
                                </button>

                                <div id="filter-menu" class="filter-menu">
                                <ul>
                                        <li><a href="#" onclick="applyFilter('release_date')">Data di Rilascio</a></li>
                                        <li><a href="#" onclick="applyFilter('alphabetical')">Ordine alfabetico</a></li>
                                        <li><a href="#" onclick="applyFilter('top_rated')">Numero di recensioni</a></li>
                                        <li><a href="#" onclick="applyFilter('highest_rated')">Media voti</a></li>
                                </ul>
                                </div>
                </div>

                <div class="homepage-container">
                        <div class="welcome">
                                <?php
                                if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
                                ?>
                                        <!-- Messaggio per utenti loggati -->
                                        Ciao <?php echo $_SESSION["user_id"]; ?>, inizia a recensire i tuoi album preferiti! 
                                        <!-- Messaggio per utenti non loggati -->
                                <?php
                                } else  {
                                        echo 'Unisciti alla nostra community di adviser, ed inizia a recensire i tuoi album preferiti!';
                                }
                                ?>
                        </div>
        
                        <?php
                        require_once 'db/config.php';

                        // Di default vogliamo visualizzare gli album dal più recente. Se invece è applicato un filtro, visualizziamo in base a ciò che vuole l'utente
                        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'release_date';
                        $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
                
                        // Crea la query dinamica in base al filtro e all'ordinamento
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
                        $result = $conn->query($sql);

                        // Se ci sono album, li mandiamo in output sottoforma di griglia
                        if ($result->num_rows > 0) {
                                echo '<div class="album-grid">';
                                while ($row = $result->fetch_assoc()) {
                                        echo '<div class="album-item">';
                                        echo '<img src="' . $row['cover'] . '" alt="' . $row['title'] . '">';
                                        echo '<p>' . $row['title'] . '</p>';
                                        echo '</div>';
                                }
                                echo '</div>';
                        } else {
                                echo '<div class="no-albums">Nessun album trovato.</div>';
                        }

                        $conn->close();
                        ?>
                </div>

                <?php include_once 'footer.php' ?>
                <script src="js/filter_album.js"></script>
        </body>
</html>
