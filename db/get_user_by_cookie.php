<?php
session_start();
require_once 'config.php';

function getUserByCookie($conn, $cookie) {
    $query = "SELECT id FROM users WHERE cookie_id = ? AND cookie_expiry > NOW()";
    $stmt = mysqli_prepare($conn, $query);
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $cookie);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $user ? $user['user_id'] : null;
    } else {
        error_log("Errore nella preparazione della query: " . mysqli_error($conn));
        return null;
    }
}

if (!isset($_SESSION["user_id"]) && isset($_COOKIE['remember_me'])) {
    $cookie = $_COOKIE['remember_me'];
    $user_id = getUserByCookie($conn, $cookie);

    if ($user_id) {
        $_SESSION["user_id"] = $user_id;
    }
}

?>
