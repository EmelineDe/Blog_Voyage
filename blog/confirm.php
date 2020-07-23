<?php


$user_id = $_GET['id'];

$token = $_GET['token'];

require 'connect.php';

$sql = $db->prepare('SELECT * FROM users WHERE idusers = ?');

$sql->execute([$user_id]);

$user = $sql->fetch();

session_start();

if ($user && $user['confirmation_token'] == $token) {


    $sql = $db->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE idusers = ?');

    $sql->execute([$user_id]);

    $_SESSION['flash']['success'] = "Votre compte a bien été validé";

    $_SESSION['auth'] = $user;

    header('location: compte.php');
} else {

    $_SESSION['flash']['danger'] = "Ce lien n'est plus valide";

    header('location: login.php');
}
