<?php
session_start();
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
                        if($_SESSION["user_id"]) {
                ?>
                        Welcome <?php echo $_SESSION["user_id"]; ?>. Click here to <a href="logout.php" tite="Logout">Logout.
                <?php
                        } else
                        echo "<h1>Please login first .</h1>";
                ?>
        </body>
</html>

