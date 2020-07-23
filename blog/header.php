<?php


if (session_status() == PHP_SESSION_NONE) {

  session_start();
}

require 'connect.php';
// require 'usersfunctions.php';


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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  <link rel="stylesheet" media="screen" href="../style/style.css">

  <!-- font  -->
  <link href="https://fonts.googleapis.com/css?family=Cinzel&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Oleo+Script&display=swap" rel="stylesheet">
  <title>blog</title>
</head>

<body>

  <header>

    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light fixed-top p-0" id="ftco-navbar">
      <div class="container-fluid">
        <a class="navbar-brand col-lg-4" href="home_B.php">
          <img class="col-lg-3" src="../images/logo_2.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <?php

        if (isset($_SESSION['auth'])) { ?>

          <div class="nav_profile collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="./index.php" id="">Acceuil</a>
              </li>
              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link changecolor" href="./blog.php">Blog</a>
              </li>
              <?php
                if ($_SESSION['auth']['role'] == 1) { ?>
                <li class="nav-item mx-2 mb-2 my-md-0">
                  <a class="nav-link changecolor" href="../admin/gestion.php">Gestion</a>
                </li>
              <?php } ?>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Destination</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="">Europe</a>
                  <a class="dropdown-item" href="">Amerique</a>
                  <a class="dropdown-item" href="">Afrique</a>
                  <a class="dropdown-item" href="">Océanie</a>
                  <a class="dropdown-item" href="">Asie</a>
                </div>
              </li>
              <li class="nav-item "><a class="nav-link" href="gallery.php" id="">Galerie</a></li>
              <li class="nav-item mx-2 mb-2 my-md-0">
                <img class="rounded" src="<?php echo $_SESSION['auth']['userImage'] ?>" alt="image de profil" width="50rem" height="50rem">
              </li>
              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link pseudo" href="./compte.php">
                  <?php echo ($_SESSION['auth']['pseudo']); ?>
                </a>
              </li>
              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link" href="deconnexion.php">
                  Deconnexion</a>
              </li>

            <?php
            } else {  ?>

              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link changecolor" href="./index.php">Accueil</a>
              </li>
              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link changecolor" href="./blog.php">Blog</a>
              </li>
              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link changecolor" href="./gallery.php">Galerie</a>
              </li>

              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link changecolor" href="<?php echo 'register.php#form' ?>" target="_self">S'inscrire</a>
              </li>
              <li class="nav-item mx-2 mb-2 my-md-0">
                <a class="nav-link changecolor" href="<?php echo 'login.php#form' ?>" target="_self">Connexion</a>
              </li>

            <?php
            }
            ?>
            </ul>
          </div>
      </div>
    </nav>

    <div class="container-fluid p-0 m-0 content">
      <div id="bg">
        <div id="bg-text" class="row no-gutters align-items-center justify-content-center">
          <div class="col-md-12 text-center">
            <h1 class="mb-4">Découvrir les merveilles du monde</h1>
            <p>Découvrez d'excellents endroits pour rester, manger, faire du shopping ou visiter des experts locaux</p>
          </div>
        </div>
      </div>

    </div>

    <!-- <script src="../js/nav.js"></script> -->
  </header>

  <?php

  if (isset($_SESSION['flash'])) {

    foreach ($_SESSION['flash'] as $type => $message) { ?>

      <div class="alert alert-<?= $type; ?>">
        <?= $message; ?>
      </div>
  <?php
    }

    unset($_SESSION['flash']);
  }
  ?>