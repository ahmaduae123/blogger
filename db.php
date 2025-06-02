<?php
$host = "localhost"; // Usually localhost
$dbname = "dbageqhs7fobdo";
$username = "ufjzzoomqznvk";
$password = "tm2savfugtmk";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
