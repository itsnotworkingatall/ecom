<?php require_once("config.php") ?>

<?php

if (isset($_GET['add'])) {

    $productId = escape_string($_GET['add']);

    $query = "SELECT * FROM products WHERE product_id = {$productId}"; //getting product stock qty in some weird way

    $query = query($query);

    confirm($query);

    while ($row = fetch_array($query)) {

        if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {

            $_SESSION['product_' . $_GET['add']] += 1;


        } else {

            setMessage('info', 'We only have ' . $row['product_quantity'] . ' available</div>');

        }

        redirect('../public/checkout.php');

    }

}


if (isset($_GET['remove'])) {

    $_SESSION['product_' . $_GET['remove']]--;

    if ($_SESSION['product_' . $_GET['remove']] < 1) {

        unset($_SESSION['product_' . $_GET['remove']]);

        setMessage('info', 'Product removed.');


    }

    redirect("../public/checkout.php");

}

if (isset($_GET['delete'])) {

    unset($_SESSION['product_' . $_GET['delete']]);

    redirect("../public/checkout.php");

}
