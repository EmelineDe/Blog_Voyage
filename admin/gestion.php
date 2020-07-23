<?php

require '../blog/connect.php';
require '../blog/function.php';
require 'adminHeader.php';

if ($_SESSION['auth']['role'] == 1) {
  echo 'Bienvenue sur le compte administrateur';
} else {
  header('location: ../blog/blog.php');
}
?>



<div class="container">
  <div id="gestionTitle">
    <h1>Gestion des articles :</h1>
  </div>
  <br>
  <div id="article"><button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#articleModal">Ajouter Article</button></div>
  <br>
  <table class="table mb-4" style="margin-top:2rem;">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>Titre</th>
        <th>Contenu</th>
        <th>Image</th>
        <th>Date de parution</th>
        <th>Action</th>
      </tr>
    </thead>
    <link rel="stylesheet" href="">
    <tbody>

      <?php
      $art = getArticles($db);
      foreach ($art as $article) { ?>

        <tr>
          <td><?= $article['idarticle'] ?></td>
          <td><?= $article['titre'] ?></td>
          <td>
            <?php
              $ext = substr($article['contenu'], 0, 70);
              $space = strrpos($ext, ' ');
              echo substr($ext, 0, $space) . ' ...'; ?></td>
          <td><img src="<?= $article['imageName'] ?>" alt="image" width="100rem" height="80rem"></td>
          <td><?=
                  $date = "";
                setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');
                echo utf8_encode(strftime("%A %d %B %G", strtotime($article['dateparution'])));
                ?>
          </td>
          <td>
            <div class="d-flex">
              <a style="color:white;text-decoration:none;" href="edit.php?id=<?= $article['idarticle'] ?>">
                <button type="button" class="btn btn-primary">Modifier</button>
              </a>
              <a href="delete.php?id=<?= $article['idarticle'] ?>"><button type="button" class="btn btn-danger bouton">Supprimer</button></a>
            </div>
          </td>
        </tr>

      <?php
      }
      ?>

    </tbody>
  </table>
</div>


<div id="articleModal" class="modal fade" role="dialog">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Nouvelle Article</h3>
              <a class="close" data-dismiss="modal">×</a>
            </div>
            <form id="form" action="add.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
              <div class="modal-body">
                <div class="form-group">
                  <label for="titre">TITRE</label>
                  <input type="text" class="form-control" id="titre" name="titre" placeholder="Enter titre" required />
                </div>
                <label for="pay">Pays</label>
                <script>
                  function selectCountry(val) {
                    $("#searchCountry").val(val);
                    $("#show_up").hide();
                  }
                </script>
                <input type="text" id="searchCountry" name="Payid">
                <div id="show_up">
                </div>
                <div class="form-group">
                  <label for="texte">TEXTE</label>
                  <textarea type="text" class="form-control" id="texte" name="texte" placeholder="Enter texte" required></textarea>
                </div>
                <input id="image" type="file" name="image" accept="image/*" required> <br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input class="btn btn-success" type="submit" value="Enregistrer" name="add">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?php require 'adminFooter.php';
