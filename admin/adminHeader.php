<?php
session_start();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Article</title>
</head>

<body>
    <header>

        <nav id="navbar" class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light fixed-top " id="ftco-navbar">
            <div class="container-fluid">
                <a class="navbar-brand col-lg-4" href="../blog/index.php">
                    <img class="col-lg-3" src="../images/logo_2.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="../blog/index.php" id="">Blog</a></li>
                        <li class="nav-item "><a class="nav-link" href="gestioncomments.php" id="">Gestion commentaires</a></li>
                        <li class="nav-item "><a class="nav-link" href="gestion.php" id="">Gestion articles</a></li>
                        <li class="nav-item "><a class="nav-link" href="../blog/deconnexion.php" id="">Deconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- 
        <script src="../js/nav.js"></script> -->
    </header>