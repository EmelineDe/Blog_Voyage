<?php


try {
    $opt =[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $db = @new PDO('mysql:host=localhost;dbname=travel_blog; charset=utf8','root', 'root', $opt);
} catch (PDOException $pdoe) {
    die('Impossible de se connecter.Err : ' .$pdoe->getMessage());
}