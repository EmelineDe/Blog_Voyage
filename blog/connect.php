<?php
try {
    $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');

    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, $opt);
} catch (PDOException $e) {
    die('Erreur de connexion à la base : ' . $e->getMessage());
}
