<?php

require 'usersfunctions.php';
require 'inc_function.php';

logged_access();

if (!empty($_POST['changepassword'])) {

    $errors = array();
    require 'connect.php';

    $mdp = protect_montexte($_POST['password']);
    $confmdp = protect_montexte($_POST['password-confirm']);




    if (empty($mdp) || empty($confmdp)) {
        $errors['password'] = 'Vous devez rentrer un mot de passe valide';
    }

    if ($mdp != $confmdp) {

        $errors['password-confirm'] = 'Les mots de passe ne correspondent pas !';
    }

    if (empty($errors)) {

        $user_id = $_POST['id'];

        $password = password_hash($mdp, PASSWORD_BCRYPT);

        $sql = $db->prepare('UPDATE users SET password = ? WHERE idusers = ?');

        $sql->execute([$password, $user_id]);

        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }
}

if (!empty($_POST['changeImage'])) {

    if (!empty($_FILES['image'])) {


        $img = basename($_FILES['image']['name']);
        $img = preg_replace('/\s/', '', $_FILES['image']);
        $path = '../images/' . $img['name'];
        $ext = strtolower(substr($img['name'], -3));
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

        if (in_array($ext, $valid_extensions)) {

            move_uploaded_file($img['tmp_name'], $path);
        } else {
            die();
        }

        require 'connect.php';

        session_start();
        $user_id = $_POST['id'];

        $sql = $db->prepare('UPDATE users SET userImage = ?  WHERE idusers = ?');

        $sql->execute([$path, $user_id]);
        var_dump($user_id);
        exit;

        $_SESSION['flash']['success'] = "Votre avatar a bien été mis à jour";
    }
}



?>

<?php require 'header.php'; ?>

<div class="container">
    <div class="row mt-4 flex-column">
        <div>
            <h1 class="text-center mt-4">Bonjour <?= $_SESSION['auth']['pseudo']; ?> </h1>
        </div>
        <form id="form" class="form-horizontal" role="form" method="POST" action="" accept-charset="utf-8">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 text-center mb-4">
                    <h2>Modifier mes informations </h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="lastpassword">Mot de passe</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-danger">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                            <input type="password" name="lastpassword" class="form-control" id="lastpassword" placeholder="Mot de passe">
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
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="password">Nouveau mot de passe</label>
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
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="password">Confirmation nouveau mot de passe</label>
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

            <div class="row mt-4">
                <div class="col-md-3"></div>
                <div class="col-md-6  text-center">
                    <input type="hidden" name="id" value=" <?= $_SESSION['auth']['idusers']; ?>">
                    <button name="changepassword" type="submit" class="btn btn-success"><i class="fa fa-user-plus  mr-3"></i>Modifier</button>
                </div>
            </div>
        </form>
        <form id="form-profil" class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 text-center mb-4">
                    <h2>Modifier image de profil </h2>
                    <hr>
                </div>
            </div>
            <div class="row mt-3">
                <br><input id="image" class="form-control col-lg-4 ml-auto mr-auto" type="file" name="image" accept="image/*" sytle="overflow:hidden;" required> <br>
            </div>
            <div class="row mt-4">
                <div class="col-md-3"></div>
                <div class="col-md-6 text-center">
                    <input type="hidden" name="id" value=" <?= $_SESSION['auth']['idusers']; ?>"">
                    <button name=" changeImage" type="submit" class="btn btn-success"><i class="fa fa-user-plus  mr-3"></i>Modifier</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>