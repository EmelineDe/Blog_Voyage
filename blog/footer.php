<?php
require 'connect.php';
require 'footer_function.php';
?>


<div id="footer" class="container-fluid">
    <div class="row p-0">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <h3 class="group-title">Contacts</h3>
            <div class="row social-list py-4 col-lg-12">
                <div class="soc-item col-lg-3">
                    <a href="https://www.facebook.com" target="_blank">
                        <div class="mbr-iconfont mbr-iconfont-social socicon-facebook socicon">
                            <img class="col-lg-8" src="../images/facebook.png" alt="facebook">
                        </div>
                    </a>
                </div>
                <div class="soc-item col-lg-3">
                    <a href="https://www.youtube.com/" target="_blank">
                        <div class="mbr-iconfont mbr-iconfont-social socicon-googleplus socicon">
                            <img class="col-lg-8" src="../images/youtube.png" alt="youtube">
                        </div>
                    </a>
                </div>
                <div class="soc-item col-lg-3">
                    <a href="https://twitter.com" target="_blank">
                        <div class="mbr-iconfont mbr-iconfont-social socicon-twitter socicon">
                            <img class="col-lg-8" src="../images/twitter.png" alt="twitter">
                        </div>
                    </a>
                </div>

                <div class="soc-item col-lg-3">
                    <a href="https://instagram.com" target="_blank">
                        <div class="mbr-iconfont mbr-iconfont-social socicon-skype socicon">
                            <img class="col-lg-8" src="../images/instagram.png" alt="instagram">
                        </div>
                    </a>
                </div>
            </div>
        </div>


        <div id="footer-img" class="col-lg-6 col-md-12 col-sm-12">
            <h3 class="group-title">Derniers articles</h3>
            <div id="trips-img" class="col-lg-8">
                <?php
                $img = footer($db);
                foreach ($img as $row) { ?>
                    <img class="trips rounded" src="<?= $row['imageName'] ?>" alt="Mobirise" width="100rem" height="80rem">
                <?php
                } ?>
            </div>
        </div>
    </div>
</div>
<div id="copy" class="col-sm-12">
    <p class="m-0 small">Copyright &copy; D.Emeline Website 2019</p>
</div>


</body>

</html>