<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php include(TEMPLATE_FRONT . DS . "top_navigation.php") ?>

<?php processTransaction() ?>

<!-- Page Content -->
<div class="container">


<!-- /.row -->

    <div class="row">

        <h1>Thank you for your order</h1>

        <?php displayMessage() ?>

    </div>
</div><!--Main Content-->


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
