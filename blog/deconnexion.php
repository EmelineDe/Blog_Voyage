<?php

session_start();

// unset($_SESSION['auth']);

// $_SESSION['flash']['success'] = 'Vous etes deconnecter';

session_destroy();

header('Location: index.php');



// setcookie('remember', NULL, -1);
