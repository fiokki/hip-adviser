<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $headerContent = '
    <div class="header">
        <div class="search">
            <form action="searchbar.php" method="GET">
                <input type="text" placeholder="Cerca..." name="search">
                <button type="submit"><img src="/~s5721355/images/search.png" alt="Search" /></button>
            </form>
        </div>
        <div class="logo">
            <a href="/~s5721355/homepage.php"> <img class="logo" src="/~s5721355/images/logo.png" alt="Hip-Adviser Logo"\> </a>
        </div>
        <nav class="nav-links">
            <ul>';

    if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
        // Header per utenti loggati
        $headerContent .= '<li><a href="/~s5721355/php/show_profile.php"> <img src="/~s5721355/images/profile/profile.png" alt="Il tuo profilo" class="profile-logo" /> Il tuo profilo </a></li>
                        <li><a href="/~s5721355/php/logout.php"> <img src="/~s5721355/images/profile/logout.png" alt="Logout" class="profile-logo" /> Logout </a></li>';
                        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                            $headerContent .= ' <li><a href="/~s5721355/admin/admin_area.php"> <img src="/~s5721355/images/profile/admin.png" alt="Logout" class="profile-logo" />Area Amministrativa</a></li>';
                        }
    } else {
        // Header per utenti non loggati
        $headerContent .= '<li><a href="/~s5721355/login_form.php">Accedi</a></li>
                           <li><a href="/~s5721355/registration_form.php">Registrati</a></li>';
    }

    $headerContent .= '</ul></nav></div>';
    echo $headerContent;
?>