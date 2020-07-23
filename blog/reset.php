<?php


require 'usersfunctions.php';
require 'inc_function.php';



if (isset($_GET['id']) && isset($_GET['token'])) {

    $user_id = $_GET['id'];
    $token = $_GET['token'];

    require 'connect.php';

    $sql = $db->prepare('SELECT * FROM users WHERE idusers = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');

    $sql->execute([$user_id, $token]);

    $user = $sql->fetch();

    if ($user) {

        if (!empty($_POST)) {

            $errors = array();
            $mdp = protect_montexte($_POST['password']);
            $confmdp = protect_montexte($_POST['password-confirm']);

            if (empty($mdp) || empty($confmdp)) {
                $errors['password'] = 'Vous devez rentrer un mot de passe valide';
            }

            if ($mdp != $confmdp) {

                $errors['password-confirm'] = 'Les mots de passe ne correspondent pas !';
            }

            if (empty($errors)) {

                $password = password_hash($mdp, PASSWORD_DEFAULT);

                $sql = $db->prepare('UPDATE users SET password = ?, reset_token = NULL, reset_at = NULL');

                $sql->execute([$password]);

                session_start();
                $_SESSION['auth'] = $user;
                $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
                header('Location: compte.php');
                exit();
            }
        }
    } else {
        session_start();
        $_SESSION['flash']['danger'] = "Ce lien n'est pas valide";
        header('Location: login.php');
        exit();
    }
} else {

    header('Location: login.php');
    exit();
}

?>


<?php require 'header.php'; ?>
<div class="container">
    <form id="form" class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data" accept-charset="utf-8">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center mb-4">
                <h2>Réinitialiser mon mot de passe :</h2>
                <hr>
            </div>
        </div>
        <div class="row  mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="password">Mot de passe</label>
            </div>
            <div class="col-md-6">
                <div class="form-group has-danger">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php
                        if (!empty($errors['password'])) {
                            echo ' <i class="fa fa-close">' . $errors['password'] . '</i>';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row  mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="password">Confirm Password</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem">
                            <i class="fa fa-repeat"></i>
                        </div>
                        <input type="password" name="password-confirm" class="form-control" id="password-confirm" placeholder="Mot de passe">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php
                        if (!empty($errors['password-confirm']) && protect_montexte($_POST['password']) != protect_montexte($_POST['password-confirm'])) {
                            echo ' <i class="fa fa-close">' . $errors['password-confirm'] . '</i>';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center" style="margin-bottom: 5rem;">
                <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i>Connexion</button>
            </div>
        </div>
    </form>
</div>

<?php

require 'footer.php';
?>