<?php
require '../blog/connect.php';

$id = $_GET['id'];

$sql = 'update commentaires set valided = 1 where idcommentaire = :id ';

$result = $db->prepare($sql);

$result->bindParam(':id', $id, PDO::PARAM_INT);

$result->execute();
header('location:gestioncomments.php');
