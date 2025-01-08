<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
    <head>
        <title> Hip-Adviser | Gestione Albums </title>
        <?php include_once '../layout-elements/head.php'; ?>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #1d1d1d;
            }

            h1.gestione-albums-title {
                color: #ffb101;
                font-size: 20px;
                font-weight: bold;
            }

            .custom-table td {
                color: whitesmoke;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .cover-img {
                width: 50px;
                height: 50px;
                object-fit: cover;
            }

            .btn-group a {
                margin-right: 5px;
            }
        </style>
    </head>

    <body>
        <?php
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: ../layout-elements/no_permiss.php");
        }

        include_once '../layout-elements/header.php';

        $sql = "SELECT albums.id, albums.title, albums.release_date, albums.cover, albums.link, artists.artist_name 
                FROM albums 
                INNER JOIN artists ON albums.artist_id = artists.id 
                ORDER BY albums.id ASC";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="container mt-5">
            <h1 class="gestione-albums-title">Gestione Albums</h1>
            
            <!-- Pulsante per inserire un nuovo album -->
            <div class="mb-3">
                <a href="insert_album.php" class="btn btn-success">Inserisci Album</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Artista</th>
                            <th>Titolo</th>
                            <th>Data Rilascio</th>
                            <th>Cover</th>
                            <th>Link</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['artist_name']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['release_date']; ?></td>
                                <td><img src="<?php echo $row['cover']; ?>" alt="Cover" class="cover-img"></td>
                                <td><a href="<?php echo $row['link']; ?>" target="_blank">Ascolta</a></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="edit_album.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Modifica</a>
                                        <a href="delete_album.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo album?');">Elimina</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <?php include_once '../layout-elements/footer.php'; ?>
    </body>
</html>
