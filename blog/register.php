<?php

require 'usersfunctions.php';
require 'inc_function.php';

session_start();

if (!empty($_POST)) {

    $errors = array();
    require 'connect.php';


    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = protect_montexte($_POST['email']);
    $mdp = protect_montexte($_POST['password']);
    $confmdp = protect_montexte($_POST['password-confirm']);


    if (empty($pseudo) || !preg_match('/^[a-zA-Z0-9_]+$/', $pseudo)) {

        $errors['pseudo'] = "Pseudo invalide ou manquant";
    } else {

        $req = $db->prepare('SELECT idusers FROM users WHERE pseudo = ?');
        $req->execute([$pseudo]);
        $user = $req->fetch();

        if ($user) {

            $errors['pseudo'] = 'Ce pseudo est déjà pris';
        }
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors['email'] = "email invalide ou manquant";
    } else {

        $req = $db->prepare('SELECT idusers FROM users WHERE email = ?');
        $req->execute([$email]);
        $user = $req->fetch();

        if ($user) {

            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
        }
    }

    $longueur = strlen($mdp);

    // var_dump($longueur);

    if (empty($mdp) || empty($confmdp)) {

        $errors['password'] = 'Vous devez rentrer un mot de passe valide';
    } else if ($longueur < 8) {

        $errors['password'] = 'Votre mot de passe doit contenir 8 caractères minimum';
    }



    if ($mdp != $confmdp) {

        $errors['password-confirm'] = 'Les mots de passe ne correspondent pas !';
    }


    require '../randomAvatar/avatar.php';
    $avatar = new Avatar($pseudo);
    $avatar->save('../randomAvatar/' . $pseudo . '.png');
    $path = $avatar->save('../randomAvatar/' . $pseudo . '.png');


    if (empty($errors)) {


        $result = $db->prepare('INSERT INTO users SET pseudo = ?, email= ?, userImage = ?, password = ?, 
        confirmation_token = ?');

        $password = password_hash($mdp, PASSWORD_DEFAULT);

        $token = random(150);

        $result->execute([$pseudo, $email, $path, $password, $token]);

        $user_id = $db->lastInsertId();


        $to = '"' . $email . '"';
        $subject = 'Confirmation de votre compte';
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
              Confirmation d\'inscription</h2>
          </div>
        
          <div style="clear: both;"></div>
          <div style="margin-top:8rem; padding: 0; background-image:url(http://localhost/blog/images/dino-unsplash.jpg); background-size: cover ;
            background-repeat:no-repeat; background-position: center center; height: 35rem; display: flex; flex-direction: column;
            flex-wrap: wrap">
            <div style="background: rgba(0, 0, 0, 0.4);width: 60%; margin-top: 7rem; margin-left: 16rem;
            padding: 2rem; border-radius: 10px 120px / 100px;">
              <h1 style="color: rgb(223, 139, 43);">
                Merci ' . $pseudo . ' pour votre inscription
              </h1>
              <h2 style="color: white;">
                Profiter du voyage sur notre blog
              </h2>
            </div>
          </div>
        
          <div>
            <h3 style=" margin-top: 3rem; margin-bottom: 5rem;">Afin de confirmer votre inscription veuillez
              cliquer sur le bouton valider
              ci-dessous :
            </h3>
        
            <button style="background-color: rgb(223, 139, 43); border:none; padding: 1rem 2rem;;border-radius: 5rem;
                    display: block; margin: auto; margin-bottom: 5rem;">
              <a style="text-decoration: none; color:white;
                 font-size: 1.5rem; font-weight: bold;" href="http://localhost/blog/blog/confirm.php?id=' . $user_id . '&token=' . $token . '">
                 Valider
              </a>
            </button>

            <h2>Passez un agréable moment sur le blog.</h2>
            <h1 style=" margin-bottom: 3rem;">Bonne Visite !</h3>
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

        $_SESSION['flash']['success'] = '<p class="messages">Un message de confirmation vous à était envoyé pour confirmer votre compte</p>';

        header('Location: login.php');
        exit();
    }
}


?>

<?php require './header.php'; ?>

<div class="container">
    <form id="form" class="form-horizontal" role="form" method="POST" action="" accept-charset="utf-8">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center mb-4">
                <h2>Inscription :</h2>
                <hr>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="pseudo">Pseudo</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                        <input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php
                        if (!empty($errors['pseudo'])) {
                            echo ' <i class="fa fa-close mr-lg-3"></i><span>' . $errors['pseudo'] . '</span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="email">Adresse E-Mail</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                        <input type="text" name="email" class="form-control" id="email" placeholder="email@example.com">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php
                        if (!empty($errors['email'])) {
                            echo ' <i class="fa fa-close mr-3"></i><span>' . $errors['email'] . '</span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="password">Mot de passe</label>
            </div>
            <div class="col-md-6">
                <div class="form-group has-danger">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Entrer un mot de passe à 8 carractères">
                    </div>
                </div>
            </div>
            <div class=" col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php
                        if (!empty($errors['password'])) {
                            echo ' <i class="fa fa-close mr-3"></i><span>' . $errors['password'] . '</span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                <label for="password">Confirmation mot de passe</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem">
                            <i class="fa fa-repeat"></i>
                        </div>
                        <input type="password" name="password-confirm" class="form-control" id="password-confirm" placeholder="Confirmez votre mot de passe">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php
                        if (!empty($errors['password-confirm']) && protect_montexte($_POST['password']) != protect_montexte($_POST['password-confirm'])) {
                            echo ' <i class="fa fa-close mr-3"></i><span>' . $errors['password-confirm'] . '</span>';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <br>
        <!-- <input id="image" class="form-control" type="hidden" name="image" accept="image/*"> <br> -->
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center" style="margin-bottom: 5rem;">
                <button type="submit" class="btn btn-success"><i class="fa fa-user-plus mr-3"></i>M'INSCRIRE</button>
            </div>
        </div>
    </form>
</div>

<?php

require 'footer.php';
?>