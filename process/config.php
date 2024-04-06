<?php
    $host = 'localhost'; // Database server address
    $database = 'if0_35225150_vibz'; // Database name
    $usr = 'root'; // Database username
    $pwd = ''; // Database password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $usr, $pwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection error : " . $e->getMessage());
    }
?>