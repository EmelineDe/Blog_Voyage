<?php

require './connect.php';
require './function.php';
?>

<?php require 'header.php'; ?>


<div class="container">


    <?php
    $articles = getArticles($db);
    foreach ($articles as $art) {
    ?>

        <div id="<?= $art['idarticle'] ?>" class="row blog">
            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    <?= $art['nom_fr_fr'] ?>
                </h3>

                <div class="blog-post">
                    <h2 class="blog-post-title"><?= $art['titre'] ?></h2>
                    <hr>
                    <img class="float-left mb-2 mt-4 mr-4" src="<?= $art['imageName'] ?>" alt="images" width="180rem" height="150rem">
                    <p class="blog-post-contenu"><?= $art['contenu'] ?></p>
                    <p class="blog-post-date">
                        <?=
                            $date = "";
                        setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');
                        echo utf8_encode(strftime("%A %d %B %G", strtotime($art['dateparution'])));
                        ?>
                    </p>
                    <p class="blog-post-comment">Voir les commentaires</p>
                    <div class="clear"></div>
                    <div class='showComment'>
                        <?php
                        $id = $art['idarticle'];
                        $coms = getCommentsbyid($db, $id);
                        foreach ($coms as $com) { ?>
                            <div class="row">
                                <div class="media comment-box">
                                    <div class="media-left">
                                        <img class="img-responsive user-photo" src="<?= $com['userImage'] ?>">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?= $com['pseudo'] ?></h4>
                                        <p><?= $com['comment_contenu'] ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                    <?php if (isset($_SESSION['auth'])) { ?>
                        <div class="addcomment">
                            <form id="commentsform" action="addcom.php" method="POST">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6 text-center mb-4">
                                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-comment"></i></div>
                                        <h4>Ajouter un commentaire :</h4>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="mb-2 mr-sm-2 mb-sm-0">
                                                <textarea type="text" name="comment" class="form-control" id="comment" placeholder="Écrire un commentaire ..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6 text-center" style="margin-bottom: 5rem;">
                                        <input type='hidden' name='idart' value="<?= $art['idarticle'] ?>">
                                        <?php
                                        $id = $_SESSION['auth']['idusers'];
                                        $userid = getusers($db, $id);
                                        echo '<input type="hidden" name="iduser" value="' . $userid['idusers'] . '">'
                                        ?>

                                        <button type="submit" class="btn btn-success"><i class="fa fa-user-plus mr-3"></i>Ajouter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <script src="../js/showDiv.js"></script>
    <script src="../js/comments.js"></script>
</div>

<?php require './footer.php'; ?>