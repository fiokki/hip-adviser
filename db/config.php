<?php
$host = 'localhost';
$username = 's5721355';
$password = 'wJcBEh9SLOmc3bM8Yx9W';
$database = 's5721355';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_set_charset($conn, "utf8");
?>
