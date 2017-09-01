<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php include(TEMPLATE_FRONT . DS . "top_navigation.php") ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>A Warm Welcome!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
            <p><a class="btn btn-primary btn-large">Call to action!</a>
            </p>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Features</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row">
        <?php
            if (isset($_GET['id']) && $_GET['id'] != null) {

                $categoryId = $_GET['id'];

            } else {
?>
            <div class='col-lg-12'>
                <div class='alert alert-warning'>
                    <p>no category id specified, displaying all products.</p>
                </div>
            </div>
<?php
                $categoryId = 0;

            }

            getProducts($categoryId);


        ?>

        </div>
    </div>
        <!-- /.row -->

<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
