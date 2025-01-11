<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once '../layout-elements/head.php' ?>
        <title> Hip-Adviser | Modifica Profilo </title>
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
                    echo "<p>Utente non trovato. Sarai reindirizzato alla homepage tra 2 secondi.</p>";
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = '../homepage.php';
                            }, 2000);
                          </script>";
                    exit();
                }
                
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                ?>
                <?php include_once '../layout-elements/header.php'; ?>
        
                <div class="profile-container">
                    <h2>Modifica Le Tue Informazioni Personali</h2>
                    <form id="updateForm" action="update_profile.php" method="POST" onsubmit="return validateForm()">

                        <div class="profile-form-group">
                            <label for="firstname">Nome:</label>
                            <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                            <div id="firstnameError" class="error"></div>
                        </div>
                        <div class="profile-form-group">
                            <label for="lastname">Cognome:</label>
                            <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                            <div id="lastnameError" class="error"></div>
                        </div>

                        <div class="profile-form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['user_name']); ?>">
                            <div id="usernameError" class="error"></div>
                        </div>

                        <div class="profile-form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            <div id="emailError" class="error"></div>
                        </div>

                        <div class="profile-checkbox-group">
                            <label for="newsletter">Iscritto alla Newsletter:</label>
                            <input type="checkbox" id="newsletter" name="newsletter" <?php echo $user['newsletter'] ? 'checked' : ''; ?>>
                        </div>

                        <div class="profile-form-buttons">
                            <button type="submit">Aggiorna Profilo</button>
                        </div>

                    </form>
                    <div id="updateError" class="error"></div>
                </div>

                <?php require_once '../layout-elements/footer.php' ?>

                <script>
                function validateForm() {
                    let isValid = true;
                    document.getElementById('firstnameError').innerText = '';
                    document.getElementById('lastnameError').innerText = '';
                    document.getElementById('usernameError').innerText = '';
                    document.getElementById('emailError').innerText = '';

                    const firstname = document.getElementById('firstname').value;
                    const lastname = document.getElementById('lastname').value;
                    const username = document.getElementById('username').value;
                    const email = document.getElementById('email').value;

                    if (firstname.length > 30) {
                        document.getElementById('firstnameError').innerText = 'Il nome non può superare i 30 caratteri.';
                        isValid = false;
                    }

                    if (lastname.length > 30) {
                        document.getElementById('lastnameError').innerText = 'Il cognome non può superare i 30 caratteri.';
                        isValid = false;
                    }

                    if (username.length > 20) {
                        document.getElementById('usernameError').innerText = 'Lo username non può superare i 20 caratteri.';
                        isValid = false;
                    }

                    if (email.length > 50) {
                        document.getElementById('emailError').innerText = 'L\'email non può superare i 50 caratteri.';
                        isValid = false;
                    } else if (!/\S+@\S+\.\S+/.test(email)) {
                        document.getElementById('emailError').innerText = 'Il formato dell\'email non è valido.';
                        isValid = false;
                    }

                    return isValid; // Non permette il submit
                }
            </script>

            <?php }
            else{
                require_once '../layout-elements/no_permiss.php';
            }?>
        </body>
</html>
