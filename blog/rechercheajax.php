<?php
require './connect.php';
require './function.php';

if (isset($_POST['valRecherche'])) {
    $rech = trim($_POST['valRecherche']);
} else {
    $rech = "";
}

$rep = search($db, $rech);
