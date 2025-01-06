<?php
require_once 'db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once 'layout-elements/head.php' ?>
        <title> Hip-Adviser | Area Personale </title>
        </head>
        <body>
            <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]){ ?>
                <?php
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT first_name, last_name, user_name, email, newsletter FROM users WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if (mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                } else {
                    echo "<p>Utente non trovato. Sarai reindirizzato alla homepage tra 3 secondi.</p>";
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'homepage.php';
                            }, 3000);
                          </script>";
                    exit();
                }
                
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                ?>
                <?php include_once 'layout-elements/header.php'; ?>
        
                <div class="profile-container">
                    <h2>Informazioni Personali</h2>
                    <form action="php/update_profile.php" method="POST">
                        <div class="profile-form-group">
                            <label for="firstname">Nome:</label>
                            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['first_name']); ?>" readonly>
                        </div>
                        <div class="profile-form-group">
                            <label for="lastname">Cognome:</label>
                            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['last_name']); ?>" readonly>
                        </div>
                        <div class="profile-form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['user_name']); ?>" readonly>
                        </div>
                        <div class="profile-form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                        </div>
                        <div class="profile-form-group">
                            <label for="newsletter">Iscritto alla Newsletter:</label>
                            <input type="checkbox" id="newsletter" name="newsletter" <?php echo $user['newsletter'] ? 'checked' : ''; ?> disabled>
                            </div>
                        <div class="profile-form-buttons">
                            <button type="button" onclick="location.href='edit_profile.php'">Modifica Profilo</button>
                            <button type="button" onclick="location.href='change_password.php'">Modifica Password</button>
                        </div>
                    </form>
                </div>

                <?php require_once 'layout-elements/footer.php' ?>
            <?php }
            else{
                require_once 'no_permiss.php';
            }?>
        </body>
</html>
