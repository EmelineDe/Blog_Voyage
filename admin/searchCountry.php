<?php

require '../blog/connect.php';
require '../blog/inc_function.php';

$_GET["keyword"];

if (!empty($_GET["keyword"])) {
    $query = "SELECT * FROM pays WHERE nom_fr_fr like '" . $_GET["keyword"] . "%' ORDER BY nom_fr_fr LIMIT 0,10";
    $result = $db->query($query);
    if (!empty($result)) {
        ?>
        <ul id="country-list">
            <?php
                    foreach ($result as $country) {
                        ?>
                <li name="test" value="<?php echo $country["idpay"]; ?>" onClick="selectCountry('<?php echo $country["nom_fr_fr"]; ?>');">
                    <?php echo $country["nom_fr_fr"]; ?></li>
            <?php } ?>
        </ul>
<?php }
} ?>

<script src="../js/country.js"></script>