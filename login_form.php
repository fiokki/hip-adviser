<!DOCTYPE html>
<html lang="it">
        <?php include_once 'head.php' ?>
        <title> Hip-Adviser | Login </title>
        </head>
        <body>
            <?php include_once 'header.php' ?>
            <div class="container">
                <h2> Inizia a recensire i tuoi album preferiti! </h2>
    
                <form id="loginForm" action="php/login.php" method="post">
            
                    <label for="email">Inserisci la tua e-mail:</label>
                    <input type="email" id='email' name="email">
                    <div id="emailError" class="error"></div>

                    <div class="pass-group">
                        <label for="pass">Inserisci la tua password:</label>
                        <input type="password" id="pass" name="pass">
                        <button type="button" id="togglePassword">
                            <img src="images/eye.png" alt="Mostra/Nascondi Password" id="eyeIcon">
                        </button>
                    </div>
                    <div id="passwordError" class="error"></div>

                    <div class="checkbox-group">
                        <label for="rememberMe">Ricordami</label>
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                    </div>

                    <input type="submit" name="submit" value="Accedi!">
                </form>
                <div id="loginError" class="error"></div>
            </div>

            <div class="register-link">
                <p>Se non sei ancora iscritto, <a href="registration_form.php">Iscriviti!</a></p>
            </div>

            <?php include_once 'footer.php' ?>
            <script src="js/validate_login_form.js"></script>
            <script src="js/show_password.js"></script>

        </body>
</html>
