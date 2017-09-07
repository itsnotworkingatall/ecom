<?php

require_once ("../../config.php");

if (isset($_GET['entity'])) {

    $entity = $_GET['entity'];

    switch ($entity) {

        case "category":
            $dbTable = "categories";
            $columnName = "cat_id";
            $redirectTo = "categories";
            $entityName = "Category";
            break;

        case "product":
            $dbTable = "products";
            $columnName = "product_id";
            $redirectTo = "products";
            $entityName = "Product";
            break;

        case "order":
            $dbTable = "orders";
            $columnName = "order_id";
            $redirectTo = "orders";
            $entityName = "Order";
            break;
    }


    if (isset($_GET['id'])) {

        $entityId = escape_string($_GET['id']);

        $query = "DELETE FROM {$dbTable} WHERE {$columnName} = $entityId ";

        $query = query($query);

        confirm($query);

        setMessage("success", $entityName . " deleted.");

    } else {

        setMessage("warning", $entityName . " was not deleted.");

    }

    redirect("../../../public/admin/index.php?" . $redirectTo);

}