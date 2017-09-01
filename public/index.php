<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php include(TEMPLATE_FRONT . DS . "top_navigation.php") ?>


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php include(TEMPLATE_FRONT . DS . "side_navigation.php") ?>

            <div class="col-md-9">

                <?php include(TEMPLATE_FRONT . DS . "slider.php") ?>

                <div class="row">

                    <?php //include(TEMPLATE_FRONT . DS . "product_thumbnail.php") ?>

                    <div><?php getProducts(0) ?></div>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
