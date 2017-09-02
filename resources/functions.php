<?php

//helper functions

function redirect($location)
{

    header("Location: $location");

}

function setMessage($type, $message)
{

    if (!empty($message)) {

        $message = '<div class="alert alert-' . $type . ' alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $message . '</div>';

        $_SESSION['message'] = $message;

    } else {

        $message = "";

    }



}

function displayMessage()
{

    if (isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }

}



function query($sql)
{

    global $connection;

    return mysqli_query($connection, $sql);


}

function confirm($result)
{

    global $connection;

    if (!$result) {

        die("Query failed: " . mysqli_error($connection));

    }

}

function escape_string($string)
{

    global $connection;

    return mysqli_real_escape_string($connection, $string);

}


function fetch_array($result)
{

    return mysqli_fetch_array($result);

}

//get products

function getProducts($categoryId)
{
    $query = "SELECT * FROM products ";

    if ($categoryId != null) {
        $query .= "WHERE product_category_id = {$categoryId} ";
    }

    $query = query($query);

    confirm($query);

    //$productsQty = mysqli_num_rows($query);


    while ($row = fetch_array($query)) {

        ?>
        <div class="col-sm-6 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?id=<?php echo $row['product_id']?>"><img src="<?php echo $row['product_image']?>" alt=""></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;<?php echo $row['product_price']?></h4>
                    <h4><a href="item.php?id={$row['product_id']}"><?php echo $row['product_title']?></a></h4>
                    <p><?php echo $row['product_short_description']?></p>
                    <a class="btn btn-primary" href="cart.php?add=<?php echo $row['product_id']?>">Add to cart</a>
                </div>
            </div>
        </div>
        <?php
    }
}

function getProductsForCategory($categoryId)
{
    $query = "SELECT * FROM products ";
    if ($categoryId != null) {
        $query .= "WHERE product_category_id = {$categoryId} ";
    }

    $query = query($query);
    confirm($query);

    //$productsQty = mysqli_num_rows($query);

    while ($row = fetch_array($query)) {

        ?>
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id=<?php echo $row['product_id']?>"><img src="<?php echo $row['product_image']?>" alt=""></a>
                    <div class="caption">
                        <h3><?php echo $row['product_title']?></h3>
                        <p><?php echo $row['product_short_description']?></p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a>
                            <a href="item.php?id=<?php echo $row['product_id']?>" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php
    }
}

function productsCount($categoryId)
{
    $query = "SELECT * FROM products ";

    if ($categoryId != null) {

        $query .= "WHERE product_category_id = {$categoryId} ";

    }

    $query = query($query);

    confirm($query);

    $productsQty = mysqli_num_rows($query);

    return $productsQty;

}

function getCategories()
{

    $query = "SELECT * FROM categories";
    $query = query($query);
    confirm($query);

    while ($row = mysqli_fetch_array($query)) {

    ?>

        <a href="category.php?id=<?php echo $row['cat_id']?>" class="list-group-item"><?php echo $row['cat_title']?></a>

    <?php

    }

}

function loginUser()
{

    if (isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = escape_string($username);
        $password = escape_string($password);

        $query = "SELECT * FROM users WHERE user_name = '{$username}' AND user_password = '{$password}'";
        $query = query($query);
        confirm($query);

        if (mysqli_num_rows($query) == 0) {

            setMessage('warning', 'Invalid username or password');

            redirect("login.php");

        } else {

            setMessage('success', "Welcome, " . $username);

            redirect("admin");

        }
    }
}



function sendMessage() //not tested))))
{

    if (isset($_POST['submit'])) {
        $mailTo  = "*********************************@***********.com";
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $headers = "From: {$name} {$email}";

        $result = mail($mailTo, $subject, $message, $headers);

        if (!$result) {

            setMessage('danger', 'Could not send the email, sorry...');

            redirect("contact.php");


        } else {

            setMessage('success', 'Email sent successfully');

            redirect("contact.php");

        }


    }

}

function cart()
{
    $total = 0;
    $allItemsQty = 0;

    foreach($_SESSION as $key => $value) {

        if ($value > 0) {

            if (substr($key, 0, 8) == "product_") {

                $strlength = strlen($key - 8);
                $id = substr($key, 8, $strlength);
                $id = escape_string($id);

                $query = "SELECT * FROM products WHERE product_id = $id";
                $query = query($query);
                confirm($query);

                while ($row = fetch_array($query)) {

                    $productId = $row['product_id'];
                    $title = $row['product_title'];
                    $price = $row['product_price'];
                    $quantity = $value;
                    $subtotal = $price * $quantity;

                    $product = <<<CUT
            <tr>
                <td>{$title}</td>
                <td>&#36;{$price}</td>
                <td>{$quantity}</td>
                <td>&#36;{$subtotal}</td>
                <td><a class="btn btn-warning" href="cart.php?remove={$productId}"><span class="glyphicon glyphicon-minus"></span></a>
                <a class="btn btn-success" href="cart.php?add={$productId}"><span class="glyphicon glyphicon-plus"></span></a>
                <a class="btn btn-danger" href="cart.php?delete={$productId}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
CUT;
                    echo $product;

                    $total += $subtotal;
                    $allItemsQty += $quantity;

                }
            }
        }

    }

$_SESSION['total'] = $total;
$_SESSION['allItemsQty'] = $allItemsQty;

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";

}

function totals($key)
{

    isset($_SESSION[$key]) ? $_SESSION[$key] : $_SESSION[$key] = "";
    echo $_SESSION[$key];

}
