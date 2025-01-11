<?php
require_once '../db/get_user_by_cookie.php';
?>
<html lang="it">
        <?php include_once '../layout-elements/head.php' ?>
        <title> Hip-Adviser | Modifica Password </title>
        </head>
        <body>
            <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]){ ?>
                
                <?php include_once '../layout-elements/header.php'; ?>
        
                <div class="profile-container">
                    <h2>Modifica La Tua Password</h2>
                    <form id="updatePasswordForm" action="update_password.php" method="POST" onsubmit="return validateForm()">

                        <div class="profile-form-group">
                            <label for="password">Inserisci la tua password attuale:</label>
                            <input type="password" id="oldPassword" name="oldPassword" required>
                            <div id="oldPasswordError" class="error"></div>
                        </div>
                        <div class="profile-form-group">
                            <label for="lastname">Inserisci la nuova passsword:</label>
                            <input type="password" id="newPassword" name="newPassword" required>
                            <div id="newPasswordError" class="error"></div>
                        </div>

                        <div class="profile-form-group">
                            <label for="username">Inserisci nuovamente la nuova password</label>
                            <input type="password" id="retypePassword" name="retypePassword" required>
                            <div id="retypePasswordError" class="error"></div>
                        </div>

                        <div class="profile-form-buttons">
                            <button type="submit">Aggiorna Password</button>
                        </div>

                    </form>
                    <div id="updatePasswordError" class="error"></div>
                </div>

                <?php require_once '../layout-elements/footer.php' ?>

                <script>
                function validateForm() {
                    let isValid = true;
                    document.getElementById('oldPasswordError').innerText = '';
                    document.getElementById('newPasswordError').innerText = '';
                    document.getElementById('retypePasswordError').innerText = '';

                    const oldPassword = document.getElementById('oldPassword').value;
                    const newPassword = document.getElementById('newPassword').value;
                    const retypePassword = document.getElementById('retypePassword').value;

                    if (newPassword.length < 8) {
                        document.getElementById('newPasswordError').innerText = 'La password deve essere lunga almeno 8 caratteri.';
                        isValid = false;
                    }

                    if (newPassword !== retypePassword) {
                        document.getElementById('retypePasswordError').innerText = 'Le password non corrispondono.';
                        isValid = false;
                    }

                    if (newPassword === oldPassword) {
                        document.getElementById('oldPasswordError').innerText = 'La nuova password inserita è uguale a quella attuale.';
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
