<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
    <head>
        <title>Hip-Adviser | Gestione Recensioni</title>
        <?php include_once '../layout-elements/head.php'; ?>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #1d1d1d;
            }

            h1.gestione-recensioni-title {
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

        // Ottieni le recensioni
        $sql = "SELECT r.id AS review_id, r.rating, r.comment, r.created_at, u.id AS user_id, u.first_name, u.last_name, a.id AS album_id, a.title AS album_title 
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                JOIN albums a ON r.album_id = a.id
                ORDER BY r.id ASC";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="container mt-5">
            <h1 class="gestione-recensioni-title">Gestione Recensioni</h1>

            <div class="table-responsive">
                <table class="table table-bordered table-striped custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Recensione</th>
                            <th>Utente</th>
                            <th>Album</th>
                            <th>Voto</th>
                            <th>Recensione</th>
                            <th>Data</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['review_id']; ?></td>
                                <td><?php echo $row['user_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                <td><?php echo $row['album_id'] . ' - ' . $row['album_title']; ?></td>
                                <td><?php echo $row['rating']; ?></td>
                                <td><?php echo substr($row['comment'], 0, 50) . '...'; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="delete_review.php?id=<?php echo $row['review_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questa recensione?');">Elimina</a>
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
        <?php require_once '../layout-elements/footer.php' ?>

    </body>
</html>
