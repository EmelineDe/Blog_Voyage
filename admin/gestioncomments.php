<?php

require '../blog/connect.php';
require '../blog/function.php';
require 'adminHeader.php';
?>

<div class="container">
    <div id="gestionTitle">
        <h1>Gestion des commentaires :</h1>
    </div>
    <br>
    <br>
    <table class="table mb-4" style="margin-top:2rem;">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Pseudo</th>
                <th>Commentaire</th>
                <th>Pays</th>
                <th>Titre Article</th>
                <th>Date de parution</th>
                <th>Action</th>
            </tr>
        </thead>
        <link rel="stylesheet" href="">
        <tbody>
            <?php
            $coms = getGestionComments($db);
            foreach ($coms as $com) { ?>

                <tr>
                    <td id="delete"><?= $com['idcommentaire'] ?></td>
                    <td><?= $com['pseudo'] ?></td>
                    <td><?= $com['comment_contenu'] ?></td>
                    <td><?= $com['nom_fr_fr'] ?></td>
                    <td><?= $com['titre'] ?></td>
                    <td>
                        <?=
                                $date = "";
                            setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');
                            echo utf8_encode(strftime("%A %d %B %G", strtotime($com['datepublication'])));
                            ?>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a style="color:white;text-decoration:none;" href="valided.php?id=<?= $com['idcommentaire'] ?>">
                                <button type="button" class="btn btn-primary">Valider</button>
                            </a>
                            <a href="deleteComments.php?id=<?= $com['idcommentaire'] ?>"><button type="button" class="btn btn-danger bouton">Supprimer</button></a>
                        </div>
                    </td>
                </tr>

            <?php
            }
            ?>

        </tbody>
    </table>
</div>

<?php require 'adminFooter.php'; ?>


<!-- <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png"> -->