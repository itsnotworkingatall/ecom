<?php require_once("../resources/config.php") ?>

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

        redirect('checkout.php');

    }

}


if (isset($_GET['remove'])) {

    $_SESSION['product_' . $_GET['remove']]--;

    if ($_SESSION['product_' . $_GET['remove']] < 1) {

        setMessage('info', 'Your shopping cart is empty');


    }

    redirect("checkout.php");

}

if (isset($_GET['delete'])) {

    $_SESSION['product_' . $_GET['delete']] = '0';

    if ($_SESSION['product_' . $_GET['remove']] < 1) {

        //setMessage('info', 'Your shopping cart is empty');
        redirect("checkout.php");

    }

}
