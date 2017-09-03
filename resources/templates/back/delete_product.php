<?php
/**
 * Created at:
 * Date: 03.09.2017
 * Time: 17:01
 */

require_once ("../../config.php");

if (isset($_GET['id'])) {

    $productId = escape_string($_GET['id']);

    $query = "DELETE FROM products WHERE product_id = $productId ";

    $query = query($query);

    confirm($query);

    setMessage("success","Product deleted.");

} else {

    setMessage("warning","Product was not deleted.");

}

redirect("../../../public/admin/index.php?products");