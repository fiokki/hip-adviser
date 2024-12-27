<!DOCTYPE html>
<html lang="it">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login</title>
            <!-- Poi inserire stile -->
        </head>

        <body>
            <!-- Poi inserire header/navbar -->
            <div class="container">
                <h2> Accedi per iniziare a recensire i tuoi album preferiti! </h2>
    
                <form id="loginForm" action="php/login.php" method="post">
            
                    <label for="email">Inserisci la tua e-mail:</label>
                    <input type="email" id='email' name="email">
                    <div id="emailError" class="error"></div>

                    <label for="pass">Inserisci la tua password:</label>
                    <input type="password" id="pass" name="pass">
                    <div id="passwordError" class="error"></div>

                    <label for="rememberMe">Ricordami</label>
                    <input type="checkbox" id="rememberMe" name="rememberMe">

                    <input type="submit" name="submit" value="Accedi!">
                </form>
                <div id="loginError" class="error"></div>
            </div>
            <!-- Poi inserire footer -->

            <script src="js/validate_login_form.js"></script>

        </body>
</html>
