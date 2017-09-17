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
            $entityImage = null;
            break;

        case "product":
            $dbTable = "products";
            $columnName = "product_id";
            $redirectTo = "products";
            $entityName = "Product";
            $entityImage = "product_image";
            break;

        case "order":
            $dbTable = "orders";
            $columnName = "order_id";
            $redirectTo = "orders";
            $entityName = "Order";
            $entityImage = null;
            break;

        case "user":
            $dbTable = "users";
            $columnName = "user_id";
            $redirectTo = "users";
            $entityName = "User";
            $entityImage = "user_image";
            break;

        case "slider":
            $dbTable = "slides";
            $columnName = "slide_id";
            $redirectTo = "slides";
            $entityName = "Slide";
            $entityImage = "slide_image";
            break;
    }


    if (isset($_GET['id'])) {

        $entityId = escape_string($_GET['id']);

        if (!empty($entityImage)) {

            $getImageFileName = "SELECT {$entityImage} FROM {$dbTable} WHERE {$columnName} = $entityId ";

            $getImageFileName = query($getImageFileName);

            confirm($getImageFileName);

            while ($row = fetch_array($getImageFileName)) {

                $imageFileName = $row[$entityImage];

                $imageFileName = UPLOAD_DIRECTORY . DS . $imageFileName;

                unlink($imageFileName);
            }
        }

        $query = "DELETE FROM {$dbTable} WHERE {$columnName} = $entityId ";

        $query = query($query);

        confirm($query);

        setMessage("success", $entityName . " deleted.");

    } else {

        setMessage("warning", $entityName . " was not deleted.");

    }

    redirect("../../../public/admin/index.php?" . $redirectTo);

}