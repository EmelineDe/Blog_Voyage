<?php
require '../blog/connect.php';
require '../blog/function.php';
require 'searchCountry.php';



if (!empty($_FILES) && !empty($_POST)) {

    $img = basename($_FILES['image']['name']);
    $img = preg_replace('/\s/', '', $_FILES['image']);
    $path = '../images/' . $img['name'];
    $ext = strtolower(substr($img['name'], -3));


    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

    if (in_array($ext, $valid_extensions)) {

        move_uploaded_file($img['tmp_name'], $path);
    } else {
        $_SESSION['flash']['danger'] = "Votre image n'est pas au bon format";
        header('gestion.php');
    }

    $titre = htmlspecialchars($_POST['titre']);
    $texte = htmlspecialchars($_POST['texte']);

    $pay = htmlspecialchars($_POST['Payid']);

    $idpay = "SELECT idpay from pays where nom_fr_fr ='" . $pay . "'";

    $idpay = $db->query($idpay);

    $id = $idpay->fetch(PDO::FETCH_ASSOC);
    $id = $id['idpay'];



    $sql = "INSERT INTO articles (titre,contenu,imageName,idpay) VALUES (:titre, :contenu, :img, :id)";

    $insert = $db->prepare($sql);

    $insert->bindParam(':titre', $titre, PDO::PARAM_STR);
    $insert->bindParam(':contenu', $texte, PDO::PARAM_STR);
    $insert->bindParam(':id', $id, PDO::PARAM_INT);
    $insert->bindParam(':img', $path, PDO::PARAM_STR);
    $insert->execute();


    header('location:./gestion.php');
}
