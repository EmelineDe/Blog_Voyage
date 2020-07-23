<?php
require 'connect.php';

if ($_POST) {


    $idart = $_POST['idart'];
    $iduser = $_POST['iduser'];
    $texte = htmlspecialchars($_POST['comment']);

    if (!empty($texte) && !empty($iduser) && !empty($idart)) {
        $sql = 'INSERT INTO commentaires (comment_contenu, idarticle, idusers) VALUES (:texte, :idart, :iduser)';

        $res = $db->prepare($sql);
        $res->bindParam(':texte', $texte, PDO::PARAM_STR);
        $res->bindParam(':idart', $idart, PDO::PARAM_INT);
        $res->bindParam(':iduser', $iduser, PDO::PARAM_INT);

        $res->execute();
    }
}
