<?php
require_once 'db/get_user_by_cookie.php';
?>
<!DOCTYPE html>
<html lang="it">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Hip-adviser</title>
            <!-- Poi inserire stile -->
        </head>

        <body>
                <h2> Questa è l'homepage! </h2>
                <?php
                        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
                ?>
                        Ciao <?php echo $_SESSION["user_id"]; ?>. Clicca qui per fare <a href="php/logout.php" tite="Logout">Logout. </h3>"
                <?php
                        } else
                        echo "<h1>Accedi, merda. <a href='login_form.php'>Login here</a></h1>";
                        ?>
        </body>
</html>

