<?php
    require_once '../db/config.php';

    function isEmailRegistered($conn, $email) {
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $isRegistered = mysqli_stmt_num_rows($stmt) > 0; // qualora 'num_rows > 0' significa che la mail è già in uso
        mysqli_stmt_close($stmt);
        return $isRegistered;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
        $email = $_POST["email"];
        $exists = isEmailRegistered($conn, $email);
        echo json_encode(["exists" => $exists]);
    } else {
        echo json_encode(["exists" => false]);
    }

?>