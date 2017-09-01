<?php require_once("../resources/config.php") ?>

<?php

if (isset($_GET['add'])) {

//    $_SESSION['product_' . $_GET['add']] += 1;
//
//    redirect('index.php');

    $productId = escape_string($_GET['add']);

    $query = "SELECT * FROM products WHERE product_id = {$productId}";

    $query = query($query);

    confirm($query);

    while ($row = fetch_array($query)) {

        if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {

            $_SESSION['product_' . $_GET['add']] += 1;


        } else {

            setMessage('info', 'We only have ' . $row['product_quantity'] . ' available</div>');

        }

        redirect('checkout.php');

    }

}
