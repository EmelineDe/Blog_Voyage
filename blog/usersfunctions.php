<?php


function debug($variable)
{

    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function random($length)
{

    $alphabet = '0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN';

    return   substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_access()
{

    if (session_status() == PHP_SESSION_NONE) {

        session_start();
    }

    if (!isset($_SESSION['auth'])) {

        $_SESSION['flash']['danger'] = 'Vous devez vous connecter pour accéder à cette partie du site';

        header('Location: login.php');

        exit();
    }
}
