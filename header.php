<?php
session_start(); // Assicurati di avere la sessione avviata

// Supponiamo che $_SESSION['user_logged_in'] contenga TRUE se l'utente è loggato
if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    // Header per utenti loggati
    $headerContent = '
        <div class="header">
            <div class="search">
                <input type="text" placeholder="ricerca" />
            </div>
            <div class="logo">
                <img src="images/logo.png" alt="Hip-Adviser Logo"/>
            </div>
            <ul class="header-right"> 
                <a href="php/logout.php"> <li>Logout </li></a>
            </ul>
        </div>
    ';
} else {
    // Header per utenti non loggati
    $headerContent = '
        <div class=header">
            <div class="search">
                <input type="text" placeholder="ricerca" />
            </div>
            <div class="logo">
                <img src="images/logo.png" alt="Hip-Adviser Logo"/>
            </div>
            <ul class="header-right">
                <a href="login_form.php"> <li> Accedi </li></a>
                <a href="registration_form.php"> <li> Registrati </li></a>
            </ul>
        </div>
    ';
}

echo $headerContent;
?>
