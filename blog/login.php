<?php


require 'usersfunctions.php';
require 'inc_function.php';



if (!empty($_POST) && !empty($_POST['pseudo']) && !empty($_POST['password'])) {

    $pseudo = protect_montexte($_POST['pseudo']);
    $mdp = protect_montexte($_POST['password']);

    require 'connect.php';

    $sql = $db->prepare('SELECT * FROM users WHERE (pseudo = :pseudo OR email = :pseudo) AND confirmed_at IS NOT NULL');

    $sql->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

    $sql->execute();

    $user = $sql->fetch();

    if ($user && password_verify($mdp, $user['password'])) {

        session_start();
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = "Vous êtes bien connecté ";

        header('location: compte.php');

        // exit();
    }

    if ($mdp !=  password_verify($mdp, $user['password']) || $pseudo != $user) {

        $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte";
    }
}

?>


<?php require './header.php'; ?>
<div class="container">
    <form id="form" class="form-horizontal" role="form" method="POST" accept-charset="utf-8">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center mb-4">
                <h2>Se Connecter :</h2>
                <hr>
            </div>
        </div>
        <div class="row  mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="pseudo">Pseudo ou email</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                        <input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo ou email">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
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
            <br>
            <div class="col-lg-12">
                <div class="col-lg-12 text-center">
                    <a href="passwordRecover.php">Mot de passe oublié</a>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center" style="margin-bottom: 5rem;">
                <button type="submit" class="btn btn-success"><i class="fa fa-user-plus mr-3"></i>Connexion</button>
            </div>
        </div>

    </form>
</div>
<?php

require 'footer.php';
?>