<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    // Header per utenti loggati
    $headerContent = '
        <div class="header">
            <div class="search">
                <input type="text" placeholder="Cerca...">
                <button type="submit"><img src="/~s5721355/images/search.png" alt="Search" /></button>
            </div>
            <div class="logo">
                <a href="/~s5721355/homepage.php"> <img class="logo" src="/~s5721355/images/logo.png" alt="Hip-Adviser Logo"\> </a>
            </div>
            <nav class="nav-links">
                <ul>
                    <li><a href="/~s5721355/layout-elements/work_in_progress.php"> <img src="/~s5721355/images/profile/profile.png" alt="Il tuo profilo" class="profile-logo" /> Il tuo profilo </a></li>
                    <li><a href="/~s5721355/php/logout.php"> <img src="/~s5721355/images/profile/logout.png" alt="Logout" class="profile-logo" /> Logout </a></li>
                </ul>
            </nav>
        </div>
    ';
} else {
    // Header per utenti non loggati
    $headerContent = '
        <div class="header">
            <div class="search">
                <input type="text" placeholder="Cerca..." name="cerca">
                <button type="submit"><img src="/~s5721355/images/search.png" alt="Search" /></button>
            </div>
            <div class="logo">
                <a href="/~s5721355/homepage.php"> <img class="logo" src="/~s5721355/images/logo.png" alt="Hip-Adviser Logo"\> </a>
            </div>
            <nav class="nav-links">
                <ul>
                    <li><a href="/~s5721355/login_form.php">Accedi</a></li>
                    <li><a href="/~s5721355/registration_form.php">Registrati</a></li>
                </ul>
            </nav>
        </div>
    ';
}

echo $headerContent;
?>