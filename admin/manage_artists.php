<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
    <head>
        <title> Hip-Adviser | Gestione Artisti </title>
        <?php include_once '../layout-elements/head.php'; ?>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #1d1d1d;
            }

            h1.gestione-artisti-title {
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

            .artist-photo {
                width: 50px;
                height: 50px;
                object-fit: cover;
                border-radius: 5px;
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

        // Ottieni gli artisti
        $sql = "SELECT id, artist_name, photo, bio FROM artists ORDER BY id ASC";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="container mt-5">
            <h1 class="gestione-artisti-title">Gestione Artisti</h1>
            
            <!-- Pulsante per inserire un nuovo artista -->
            <div class="mb-3">
                <a href="../layout-elements/work_in_progress.php" class="btn btn-success">Inserisci Artista</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome Artista</th>
                            <th>Foto</th>
                            <th>Bio</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['artist_name']; ?></td>
                                <td><img src="<?php echo $row['photo']; ?>" alt="Foto Artista" class="artist-photo"></td>
                                <td><?php echo substr($row['bio'], 0, 100) . '...'; ?></td> <!-- Mostro solo una parte della bio -->
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="../layout-elements/work_in_progress.php" class="btn btn-primary btn-sm">Modifica</a>
                                        <a href="../layout-elements/work_in_progress.php" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo artista?');">Elimina</a>
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
