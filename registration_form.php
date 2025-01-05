<!DOCTYPE html>
<html lang="it">
        <?php include_once 'layout-elements/head.php' ?>
        <title> Hip-Adviser | Registrazione </title>
        </head>
        <body>
            <?php include_once 'layout-elements/header.php' ?>
            <div class="container">
                <h2> Inizia a recensire i tuoi album preferiti! </h2>

                <form id="registrationForm" action="php/registration.php" method="post">

                        <label for="firstname">Il tuo nome:</label>
                        <input type="text" id="firstname" name="firstname">
                        <div id="firstnameError" class="error"></div>

                        <label for="lastname">Il tuo cognome:</label>
                        <input type="text" id="lastname" name="lastname">
                        <div id="lastnameError" class="error"></div>

                        <label for="username">Scegli il tuo username: </label>
                        <input type="text" id="username" name="username">
                        <div id="usernameError" class="error"></div>

                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email">
                        <div id="emailError" class="error"></div>

                        <div class="pass-group">
                            <label for="pass">Password:</label>
                            <input type="password" id="pass" name="pass">
                            <button type="button" id="togglePassword">
                                <img src="images/eye.png" alt="Mostra/Nascondi Password" id="eyeIcon">
                            </button>
                        </div>
                        <div id="passwordError" class="error"></div>

                        <label for="confirm">Conferma la password:</label>
                        <input type="password" id="confirm" name="confirm">
                        <div id="retypePasswordError" class="error"></div>

                        <div class="checkbox-group">
                            <label for="newsletter">Voglio iscrivermi alla newsletter</label>
                            <input type="checkbox" id="newsletter" name="newsletter">
                        </div>

                        <input type="submit" name="submit" value="Iscriviti!">
                </form>
            </div>

            <div class="login-link">
                <p>Se sei già iscritto, <a href="login_form.php">accedi!</a></p>
            </div>

        <?php include_once 'layout-elements/footer.php' ?>
        <script src="js/validate_registration_form.js"></script>
        <script src="js/show_password.js"></script>

        </body>
</html>
