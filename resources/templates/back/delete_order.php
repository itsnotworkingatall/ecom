<?php
/**
 * Created at:
 * Date: 03.09.2017
 * Time: 17:01
 */

require_once ("../../config.php");

if (isset($_GET['id'])) {

    $orderId = escape_string($_GET['id']);

    $query = "DELETE FROM orders WHERE order_id = $orderId ";

    $query = query($query);

    confirm($query);

    setMessage("success","Order deleted.");

} else {

    setMessage("warning","Order was not deleted.");

}

redirect("../../../public/admin/index.php?orders");