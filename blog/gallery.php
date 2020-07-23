<?php
require 'connect.php';
require 'function.php';
require 'header.php';
?>
<div class="container">
    <?php
    $images = getImage($db);
    $value_pays = "";
    foreach ($images as $img) {
        if ($img['nom_fr_fr'] != $value_pays) {
            $value_pays = $img['nom_fr_fr'];
            ?>

            <h1 class="font-weight-light text-center  mt-4 mb-0"><?= $img['nom_fr_fr'] ?></h1>
            <hr class="mt-2 mb-5">
        <?php
            }
            ?>

        <div class="row text-center text-lg-left ">

            <div class="col-lg-12 col-md-4 col-6">
                <img class="img-fluid img-thumbnail col-lg-4" src="<?= $img['imageName'] ?>" alt="">
            </div>
        </div>

    <?php } ?>
</div>

<?php
require 'footer.php';
?>