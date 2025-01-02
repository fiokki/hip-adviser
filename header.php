<?php
session_start(); // Assicurati di avere la sessione avviata

// Supponiamo che $_SESSION['user_logged_in'] contenga TRUE se l'utente è loggato
if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    // Header per utenti loggati
    $headerContent = '
        <div class="header">
            <div class="search">
                <input type="text" placeholder="Cerca...">
                <buttton>🔍</button>
            </div>
            <div class="logo">
                <img class="logo" src="images/logo" alt="Hip-Adviser Logo"\>
            </div>
            <nav class="nav-links">
                <ul>
                    <li><a href="php/logout.php>Logout</a></li>
                </ul>
            </nav>
        </div>
    ';
} else {
    // Header per utenti non loggati
    $headerContent = '
        <div class="header">
            <div class="search">
                <input type="text" placeholder="Cerca...">
                <buttton>🔍</button>
            </div>
            <div class="logo">
                <img class="logo" src="images/logo" alt="Hip-Adviser Logo"\>
            </div>
            <nav class="nav-links">
                <ul>
                    <li><a href="login_form.php"">Accedi</a></li>
                    <li><p>|</p></li>
                    <li><a href="register_form.php">Registrati</a></li>
                </ul>
            </nav>
        </div>
    ';
}

echo $headerContent;
?>
