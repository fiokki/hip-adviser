<!DOCTYPE html>
<html lang="it">
        <?php include 'head.php' ?>
        <title>Registrazione</title>
        <body>
        <!-- Poi inserire header/navbar -->
            <div class="container">
                <h2> Iscriviti, ed inizia a recensire i tuoi album preferiti! </h2>

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

                        <label for="pass">Password:</label>
                        <input type="password" id="pass" name="pass">
                        <div id="passwordError" class="error"></div>

                        <label for="confirm">Conferma la password:</label>
                        <input type="password" id="confirm" name="confirm">
                        <div id="retypePasswordError" class="error"></div>

                        <label for="newsletter">Voglio iscrivermi alla newsletter</label>
                        <input type="checkbox" id="newsletter" name="newsletter">
                        
                        <input type="submit" name="submit" value="Iscriviti!">
                </form>
            </div>
        <!-- Poi inserire footer -->

        <script src="js/validate_registration_form.js"></script>

        </body>
</html>
