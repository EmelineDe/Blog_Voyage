<?php


require 'usersfunctions.php';
require 'inc_function.php';



if (!empty($_POST) && !empty($_POST['email']) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

  $email = protect_montexte($_POST['email']);


  require 'connect.php';

  $sql = $db->prepare('SELECT * FROM users WHERE (email = :email) AND confirmed_at IS NOT NULL');

  $sql->bindParam(':email', $email, PDO::PARAM_STR);

  $sql->execute();

  $user = $sql->fetch();

  if ($user) {

    session_start();

    $reset_token = random(150);

    $sql = $db->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE idusers = ?');

    $user_id =  $user['idusers'];

    $sql->execute([$reset_token, $user_id]);

    $_SESSION['flash']['success'] = "Un email vous a été envoyé afin de réinitialiser votre mot de passe";

    $to = '"' . $email . '"';
    $subject = 'Demande d\'un nouveau mot de passe';
    $txt = '
        
        <html lang="en" style="box-sizing:border-box; font-family:sans-serif;">
          <head>
             <meta charset="UTF-8">
          </head>
          <body style="margin: 0; padding: 0; width: 100%; font-family: \'Lucida Sans\', \'Lucida Sans Regular\', \'Lucida Grande\', \'Lucida Sans \', Geneva, Verdana, sans-serif;
          text-align: center;">
        
          <div style="width: 100%; margin: auto; padding: 0;position: absolute;top: 0;text-align: center;">
            <img src="http://localhost/blog/images/logo_2.png" alt="logo" width="15%" height="15%" style="float: left; padding-left: 5rem;">
        
            <h2 style="text-align: center; margin-top:2em; padding-right: 5rem;
              display: inline-block;">
              Réinitialisation de votre mot de passe</h2>
          </div>
        
          <div style="clear: both;"></div>
          <div style="margin-top:8rem; padding: 0; background-image:url(http://localhost/blog/images/dino-unsplash.jpg); background-size: cover ;
            background-repeat:no-repeat; background-position: center center; height: 35rem; display: flex; flex-direction: column;
            flex-wrap: wrap">
            <div style="background: rgba(0, 0, 0, 0.4);width: 60%; margin-top: 7rem; margin-left: 16rem;
            padding: 2rem; border-radius: 10px 120px / 100px;">
              <h2 style="color: white;">
                Profiter du voyage sur notre blog
              </h2>
            </div>
          </div>
        
          <div>
            <h3 style=" margin-top: 3rem; margin-bottom: 5rem;">Afin de réinitialiser votre mot de passe veuillez
              cliquer sur le réinitialiser
              ci-dessous :
            </h3>
        
            <button style="background-color: rgb(223, 139, 43); border:none; padding: 1rem 2rem;;border-radius: 5rem;
                    display: block; margin: auto; margin-bottom: 5rem;">
              <a style="text-decoration: none; color:white;
                 font-size: 1.5rem; font-weight: bold;" href="http://localhost/blog/blog/reset.php?id=' . $user_id . '&token=' . $reset_token . '">
                 Réinitialiser
              </a>
            </button>

            <h2>Passez un agréable moment sur le blog.</h2>
            <h1 style=" margin-bottom: 3rem;">Bonne Viste !</h3>
          </div>
        
          <footer style="background-color:rgb(223, 139, 43);">
            <div style="padding-top: 3rem; padding-bottom: 3rem;">
              <a style="text-decoration: none; color: white; letter-spacing: 0.5rem; font-weight: bold; font-size: 2rem;
              " href="#">Backpacking Travel</a>
            </div>
        
            <div style="display: flex; flex-direction: row; justify-content: space-evenly; padding-bottom: 3rem;">
              <img src="http://localhost/blog/images/facebook.png" alt="facebook" width="3%" height="3%">
              <img src="http://localhost/blog/images/instagram.png" alt="instagram" width="3%" height="3%">
              <img src="http://localhost/blog/images/twitter.png" alt="twitter" width="3%" height="3%">
              <img src="http://localhost/blog/images/youtube.png" alt="youtube" width="3%" height="3%">
            </div>
        
          </footer>
        
        </body>
        
        ';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@exemple.com" . "\r\n" . "Reply-To: toto@exemple.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();
    "CC: '" . $email . "'";


    mail($to, $subject, $txt, $headers);

    header('Location: login.php');

    exit();
  } else {

    $_SESSION['flash']['danger'] = "Aucun compte ne correspond à cet adresse";
  }
}

?>


<?php require 'header.php'; ?>
<div class="container">
  <form id="form" class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data" accept-charset="utf-8">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6  text-center mb-4">
        <h2>Mot de passe oublier :</h2>
        <hr>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-3 field-label-responsive text-center">
        <label for="email">Email</label>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <div class="input-group mb-2 mr-sm-2 mb-sm-0">
            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
            <input type="email" name="email" class="form-control" id="email" placeholder="exemple@email.com">
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-3"></div>
      <div class="col-md-6 text-center" style="margin-bottom: 5rem;">
        <button type="submit" class="btn btn-success"><i class="fa fa-user-plus mr-3"></i>Envoyer</button>
      </div>
    </div>
  </form>
</div>

<?php

require 'footer.php';
?>