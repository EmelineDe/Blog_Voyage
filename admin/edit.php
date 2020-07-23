<?php
require '../blog/connect.php';
require '../blog/function.php';
require 'searchCountry.php';


$idart = $_GET['id'] ?? -1;

if ($idart == -1) {
    die('access direct impossible');
}
$update = $_POST['id'] ?? -1;

if ($update != -1) {

    if ($_FILES && $_POST) {

        if (!empty($_POST['titre']) || !empty($_POST['texte']) || !empty($_FILES['image'])) {

            $img = basename($_FILES['image']['name']);
            $img = preg_replace('/\s/', '', $_FILES['image']);
            $path = '../images/' . $img['name'];
            $ext = strtolower(substr($img['name'], -3));
            $valid_extensions = array('.jpeg', '.jpg', '.png', '.gif');

            if (in_array($ext, $valid_extensions)) {

                move_uploaded_file($img['tmp_name'], $path);
            }

            $pay = htmlspecialchars($_POST['Payid']);

            $idpay = "SELECT idpay from pays where nom_fr_fr ='" . $pay . "'";

            $idpay = $db->query($idpay);

            $id = $idpay->fetch(PDO::FETCH_ASSOC);
            $id = $id['idpay'];

            $titre = htmlspecialchars($_POST['titre']);
            $texte = htmlspecialchars($_POST['texte']);

            $sql = 'update articles set ';
            $sql .= 'titre = :titre, ';
            $sql .= 'contenu = :contenu, ';
            $sql .= 'imageName = :img, ';
            $sql .= 'idpay = :idpay ';
            $sql .= 'where idarticle = :id ';



            $result = $db->prepare($sql);

            $result->bindParam(':titre', $titre, PDO::PARAM_STR);
            $result->bindParam(':contenu', $texte, PDO::PARAM_STR);
            $result->bindParam(':idpay', $id, PDO::PARAM_INT);
            $result->bindParam(':img', $path, PDO::PARAM_STR);
            $result->bindParam(':id', $update, PDO::PARAM_INT);

            $result->execute();
            header('location: ./gestion.php');
        }
    }
}

?>
<?php require 'adminHeader.php'; ?>



<?php
$art = getArticleById($db, $idart);
?>
<div id='edit' class="container">
    <form id="form" action="./edit.php?id=<?= $idart ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Editer article :</h2>
                <hr>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="titre">titre</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input type="text" class="form-control" id="titre" name="titre" value="<?= $art['titre'] ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="pay">Pay</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <script>
                            function selectCountry(val) {
                                $("#searchCountry").val(val);
                                $("#show_up").hide();
                            }
                        </script>
                        <input type="text" id="searchCountry" name="Payid" value="<?= $art['nom_fr_fr'] ?>">
                    </div>
                </div>
            </div>
        </div>
        <div id="show_up"></div>
        <div class="row mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="texte">Texte</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <textarea type="text" class="form-control" id="texte" name="texte" rows="10"><?= $art['contenu'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-3 field-label-responsive">
                <label for="texte">Texte</label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input id="image" type="file" name="image" accept="image/*" required> <br>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="<?= $art['idarticle'] ?>">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center" style="margin-bottom: 5rem;">
                <button class="btn_add btn btn-info type" submit name="sauver" value="Sauver">Sauver</button>
                <button class="retour btn btn-info type" name="retour">
                    <a href='../admin/gestion.php'>Annuler</a>
                </button>
            </div>
        </div>
        <br>
    </form>
</div>

<?php require 'adminFooter.php'; ?>