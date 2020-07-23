<?php
require '../blog/connect.php';


$id = $_GET['id'] ?? -1;
if ($id == -1) {
    die('access direct impossible');
}



$sql = "DELETE FROM articles where idarticle = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
header('location: gestion.php');
