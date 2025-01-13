<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
        <title> Hip-Adviser | Gestione Utenti </title>
        <?php include_once '../layout-elements/head.php' ?>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
        body {
            background-color: #1d1d1d;
        }

        h1.gestione-utenti-title {
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
        </style>
    </head>

    <body>
        <?php
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: ../layout-elements/no_permiss.php");
        }

        include_once '../layout-elements/header.php';

        $sql = "SELECT id, first_name, last_name, user_name, email, role, newsletter, created_at FROM users ORDER BY id ASC";
        $result = mysqli_query($conn, $sql);
    ?>
    <div class="container mt-5">
        <h1 class="gestione-utenti-title">Gestione Utenti</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Email</th>
                        <th>Ruolo</th>
                        <th>Data Registrazione</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo ucfirst($row['role']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="../layout-elements/work_in_progress.php" class="btn btn-primary btn-sm">Modifica</a>
                                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo utente?');">Elimina</a>
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