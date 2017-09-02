<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php include(TEMPLATE_FRONT . DS . "top_navigation.php") ?>

<?php

    if (isset($_GET['tx'])) {

        $amount = $_GET['amt']; // 64%2e95
        $transaction = $_GET['tx']; // 1JH21726JM507562V
        $status = $_GET['st']; // Completed
        $currency = $_GET['cc']; // USD

        $amount = escape_string($amount);
        $transaction = escape_string($transaction);
        $status = escape_string($status);
        $currency = escape_string($currency);

        $query = "INSERT INTO orders (order_amount, order_transaction, order_status, order_currency) ";
        $query .= "VALUES ('{$amount}', '{$transaction}', '{$status}', '{$currency}')";

        $query = query($query);
        confirm($query);
        session_destroy();





    } else {

        redirect('index.php');

    }

?>

<!-- Page Content -->
<div class="container">


<!-- /.row -->

    <div class="row">

        <h1>Thank you for your order</h1>

        <?php displayMessage() ?>

    </div>
</div><!--Main Content-->


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
