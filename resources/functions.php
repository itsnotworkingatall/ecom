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

    }
}

function displayMessage()
{

    if (isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }

}

function lastId()
{

    global $connection;

    return mysqli_insert_id($connection);

}



function query($sql)
{

    global $connection;

    return mysqli_query($connection, $sql);


}

function confirm($query)
{

    global $connection;

    if (!$query) {

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

function getProducts($categoryId) // on frontend, for category and index.
{

    $query = "SELECT * FROM products WHERE product_quantity >= 1 ";

    if ($categoryId != null) {
        $query .= "AND product_category_id = {$categoryId} ";
    }

    $query = query($query);

    confirm($query);

    //$productsQty = mysqli_num_rows($query);


    while ($row = fetch_array($query)) {

        $image = $row['product_image'];

        $image = pathToImage("frontend", $image);

        ?>
        <div class="col-sm-6 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?id=<?php echo $row['product_id']?>"><img src="<?php echo $image ?>" alt=""></a>
                <div class="caption">
                    <h4 class="pull-right">&#36;<?php echo $row['product_price']?></h4>
                    <h4><a href="item.php?id=<?php echo $row['product_id']?>"><?php echo $row['product_title']?></a></h4>
                    <p><?php echo $row['product_short_description']?></p>
                    <a class="btn btn-primary" href="../resources/cart.php?add=<?php echo $row['product_id']?>">Add to cart!</a>
                </div>
            </div>
        </div>
        <?php
    }
}

function getProductsForCategory($categoryId)  // NOT USED
{
    $query = "SELECT * FROM products ";
    if ($categoryId != null) {
        $query .= "WHERE product_category_id = {$categoryId} ";
    }

    $query = query($query);
    confirm($query);

    //$productsQty = mysqli_num_rows($query);

    while ($row = fetch_array($query)) {

        $image = $row['product_image'];

        if (!preg_match("/http\:\/\//i", $image))
        {
            $image = "../" . pathToImage($image);
        }

        ?>
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <a href="item.php?id=<?php echo $row['product_id']?>"><img src="<?php echo $image ?>" alt=""></a>
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
    $query = "SELECT * FROM products WHERE product_quantity >= 1 ";

    if ($categoryId != null) {

        $query .= "AND product_category_id = {$categoryId} ";

    }

    $query = query($query);

    confirm($query);


    $productsQty = mysqli_num_rows($query);

    return $productsQty;

}

function getCategories($isbackend)
{

    $query = "SELECT * FROM categories";
    $query = query($query);
    confirm($query);

    $template_path = TEMPLATES;

    if ($isbackend == false) {

        while ($row = mysqli_fetch_array($query)) {

            ?>

            <a href="category.php?id=<?php echo $row['cat_id']?>" class="list-group-item"><?php echo $row['cat_title']?></a>

            <?php

        }

    } else {

        while ($row = mysqli_fetch_array($query)) {

            ?>

            <tr>
                <td><?php echo $row['cat_id']?></td>
                <td><a href="index.php?edit_category&id=<?php echo $row['cat_id']?>" ><?php echo $row['cat_title']?></a></td>
                <td><a class="btn btn-danger" href="<?php echo $template_path ?>/back/delete.php?entity=category&id=<?php echo $row['cat_id']?>"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>

            <?php

        }

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

            $_SESSION['username'] = $username;

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

    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $qty = 1;


    foreach ($_SESSION as $key => $value) {

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
                    $image = $row['product_image'];
                    $quantity = $value;
                    $subtotal = $price * $quantity;

                    $image = pathToImage("frontend", $image);



                    $product = <<<CUT
            <tr>
                <td>{$title}</td>
                <td><img src="{$image}" alt=""></td>
                <td>&#36;{$price}</td>
                <td>{$quantity}</td>
                <td>&#36;{$subtotal}</td>
                <td><a class="btn btn-warning" href="../resources/cart.php?remove={$productId}"><span class="glyphicon glyphicon-minus"></span></a>
                <a class="btn btn-success" href="../resources/cart.php?add={$productId}"><span class="glyphicon glyphicon-plus"></span></a>
                <a class="btn btn-danger" href="../resources/cart.php?delete={$productId}"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>

            <input type="hidden" name="item_name_{$item_name}" value="{$title}">
            <input type="hidden" name="item_number_{$item_number}" value="{$productId}">
            <input type="hidden" name="amount_{$amount}" value="{$price}">
            <input type="hidden" name="quantity_{$qty}" value="{$quantity}">
CUT;
                    echo $product;

                    $item_name++;
                    $item_number++;
                    $amount++;
                    $qty++;

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

/**
 * @param $key
 * @echo string
 */
function totals($key)
{

    isset($_SESSION[$key]) ? $_SESSION[$key] : $_SESSION[$key] = "";
    echo $_SESSION[$key];

}

/**
 * @echo paypal button
 */
function paypalButton()
{
    if (isset($_SESSION['allItemsQty']) && $_SESSION['allItemsQty'] > 0 ) {

$button = <<<BUTTON
<input type="image" name="upload"
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
alt="PayPal - The safer, easier way to pay online">
BUTTON;

    echo $button;
    }
}


function processTransaction()
{
    $total = 0;
    $allItemsQty = 0;

    if (isset($_GET['tx'])) {

        $amount = $_GET['amt']; // 64%2e95
        $transaction = $_GET['tx']; // 1JH21726JM507562V
        $status = $_GET['st']; // Completed
        $currency = $_GET['cc']; // USD

        $amount = escape_string($amount);
        $transaction = escape_string($transaction);
        $status = escape_string($status);
        $currency = escape_string($currency);



        $sendOrdrer = <<<SQL
INSERT INTO orders (order_amount
                  , order_transaction
                  , order_status
                  , order_currency
                  , order_date
                   ) 
            VALUES ('{$amount}'
                  , '{$transaction}'
                  , '{$status}'
                  , '{$currency}'
                  , now()
                   ) 
SQL;

        $sendOrdrer = query($sendOrdrer);

        $lastId = lastId();

        confirm($sendOrdrer);

        foreach ($_SESSION as $key => $value) {

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


                        $total += $subtotal;
                        $allItemsQty += $quantity;

                        $insertReport = <<<SQL
INSERT INTO reports (order_id
                   , product_id
                   , product_title
                   , product_price
                   , product_qty
                    ) 
             VALUES ('{$lastId}'
                   , '{$productId}'
                   , '{$title}'
                   , '{$price}'
                   , '{$quantity}'
                    ) 
SQL;




                        $insertReport = query($insertReport);
                        confirm($insertReport);

                    }
                }
            }

        }

        session_destroy();

    } else {

        redirect('index.php');

    }

    $_SESSION['total'] = $total;
//    $_SESSION['allItemsQty'] = $allItemsQty;

//    echo "<pre>";
//    var_dump($_SESSION);
//    echo "</pre>";

}


/*******************************************  BACKEND   ******************************************/

function displayOrders()
{

    $query = "SELECT * FROM orders";
    $query = query($query);
    confirm($query);

    while ($row = fetch_array($query)) {
        $template_path = TEMPLATES;

        $orders = <<<DELIMITER

<tr>
    <td>{$row['order_id']}</td>
    <td>{$row['order_amount']}</td>
    <td>{$row['order_transaction']}</td>
    <td>{$row['order_currency']}</td>
    <td>{$row['order_status']}</td>
    <td>{$row['order_date']}</td>
    <td><a class="btn btn-danger" href="{$template_path}/back/delete.php?entity=order&id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>


DELIMITER;

        echo $orders;

    }

}



function displayProductsGrid() // backend: "view products" grid.
{
    $query = "SELECT * FROM products";

    $query = query($query);

    confirm($query);

    while ($row = fetch_array($query)) {

        $productStatus = getProductStatus($row['product_status']);

        $categoryName = getCategoryNameById($row['product_category_id']);

        $image = $row['product_image'];

        $image = pathToImage("backend", $image);

        $template_path = TEMPLATES;

        $product = <<<PRODUCT
<tr>
   <th>{$row['product_id']}</th>
   <th>{$row['product_title']}</th>
   <th><a href="index.php?edit_product&id={$row['product_id']}"><img src="{$image}" height="60px"></a></th>
   <th>$categoryName</th>
   <th>{$row['product_price']}</th>
   <th>{$row['product_quantity']}</th>
   <th>$productStatus</th>
   <th><a class="btn btn-warning" href="index.php?edit_product&id={$row['product_id']}"><span class="glyphicon glyphicon-edit"></span></a></th>
   <th><a class="btn btn-danger" href="{$template_path}/back/delete.php?entity=product&id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></th>
</tr>

PRODUCT;

        echo $product;

    }
}

/**
 * @param boolean $bool
 * @return string
 */
function getProductStatus($bool)
{
    if ($bool == 0) {

        $status = "Draft";

    } else {

        $status = "Published";

    }

    return $status;
}

/**
 * @param $string
 * @return int
 */
function setProductStatus($string)
{
    if ($string == "Publish" || $string == "Update") {

        $status = 1;

    } else {

        $status = 0;

    }

    return $status;
}

/******** add product ********/

function addProduct()
{

    if (isset($_POST['publish'])) {

        $product_title             = escape_string($_POST['product_title']);
        $product_description       = escape_string($_POST['product_description']);
        $product_short_description = escape_string($_POST['product_short_description']);
        $product_price             = escape_string($_POST['product_price']);
        $product_category          = escape_string($_POST['product_category']);
        $product_quantity          = escape_string($_POST['product_quantity']);
        $product_status            = escape_string($_POST['publish']);
        $product_status            = setProductStatus($product_status);

        $product_image       = $_FILES['file']['name'];
        $image_temp_location = $_FILES['file']['tmp_name'];

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        $product_image = escape_string($product_image);

        $query = <<<SQL
INSERT INTO products (product_title
                    , product_category_id
                    , product_price
                    , product_quantity
                    , product_description
                    , product_short_description
                    , product_image
                    , product_status
                     ) 
              VALUES ('{$product_title}'
                    , '{$product_category}'
                    , '{$product_price}'
                    , '{$product_quantity}'
                    , '{$product_description}'
                    , '{$product_short_description}'
                    , '{$product_image}'
                    , '{$product_status}'
                     ) 
SQL;

        $query = query($query);
        confirm($query);
        setMessage("success", "Product added successfully");
        redirect("index.php?products");
    }

}


function updateProduct()
{

    if (isset($_POST['update'])) {

        $product_id                = escape_string($_GET['id']);
        $product_title             = escape_string($_POST['product_title']);
        $product_description       = escape_string($_POST['product_description']);
        $product_short_description = escape_string($_POST['product_short_description']);
        $product_price             = escape_string($_POST['product_price']);
        $product_category          = escape_string($_POST['product_category']);
        $product_quantity          = escape_string($_POST['product_quantity']);
        $product_status            = escape_string($_POST['update']);
        $product_status            = setProductStatus($product_status);

        $product_image       = $_FILES['file']['name'];
        $image_temp_location = $_FILES['file']['tmp_name'];

        if (empty($product_image)) {

            $query = "SELECT product_image FROM products WHERE product_id = $product_id ";

            $query = query($query);

            confirm($query);

            while($row = fetch_array($query)) {

                $product_image = $row['product_image'];

            }

        }



        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        $product_image = escape_string($product_image);

        $query = <<<SQL
UPDATE products SET product_title             = '{$product_title}'
                  , product_category_id       = '{$product_category}'
                  , product_price             = '{$product_price}'
                  , product_quantity          = '{$product_quantity}'
                  , product_description       = '{$product_description}'
                  , product_short_description = '{$product_short_description}'
                  , product_image             = '{$product_image}'
                  , product_status            = '{$product_status}' 
WHERE product_id = {$product_id}
SQL;



        $query = query($query);
        confirm($query);
        setMessage("success", "Product updated successfully");
        redirect("index.php?products");
    }

}


function addCategory()
{
    if (isset($_POST['addcategory']) && !null == $_POST['category_title']) {

        $categoryTitle = escape_string($_POST['category_title']);

        $query = "INSERT INTO categories (cat_title) VALUES ('{$categoryTitle}') ";

        $query = query($query);

        confirm($query);

        setMessage("success", "Category added successfully");

        redirect("index.php?categories");

    } else {

        setMessage("warning", "Category name can not be empty");

    }

}



function updateCategory()
{

    if (isset($_POST['update'])) {

        $categoryId     = escape_string($_GET['id']);
        $categoryTitle  = escape_string($_POST['category_title']);


        $query = "UPDATE categories SET cat_title = '{$categoryTitle}' WHERE cat_id = {$categoryId} ";

        $query = query($query);
        confirm($query);
        setMessage("success", "Category updated successfully");
        redirect("index.php?categories");
    }

}


/**
 * @param $currentCategoryId
 * @echo categories list with
 */
function getCategoriesList($currentCategoryId)
{
    $query = "SELECT * FROM categories";
    $query = query($query);
    confirm($query);

    while ($row = fetch_array($query)) {

        $categoryId = $row['cat_id'];
        $categoryTitle = $row['cat_title'];

        $category = '<option value="' . $categoryId . '"';

        if ($currentCategoryId == $categoryId) {

            $category .= " selected";

        }

        $category .= '>' . $categoryTitle . '</option>';

        echo $category;

    }

}


/**
 * receiving category id
 * @param int $categoryId
 *
 * returning category title
 * @return string
 */
function getCategoryNameById($categoryId)
{

    $cat_title = "Not found";

    $categoryName = "SELECT cat_title FROM categories WHERE cat_id = $categoryId";
    $categoryName = query($categoryName);
    confirm($categoryName);

    while ($key = fetch_array($categoryName)) {

        $cat_title = $key['cat_title'];

    }

    return $cat_title;

}

/**
 * gets a filename, returns a path to the file from the "public" folder
 * e.g. ../resources/uploads/$imagefilename
 * @param string $imageNameFromDb
 * @param string $frontendOrBackend
 * @return string
 */
function pathToImage($frontendOrBackend, $imageNameFromDb)
{

    if (!$imageNameFromDb == null) {

        if ($frontendOrBackend == "backend") {

            $frontendOrBackend = "../";

        } else {

            $frontendOrBackend = "";

        }

        if (!preg_match("/https?\:\/\//i", $imageNameFromDb)) {
            $imageNameFromDb = $frontendOrBackend . "../resources/uploads/" . $imageNameFromDb;;
        }

        return $imageNameFromDb;

    } else {

        return $imageNameFromDb;

    }
}


function displayReportsGrid() // backend: "view reports" grid.
{
    $query = "SELECT * FROM reports";

    $query = query($query);

    confirm($query);

    while ($row = fetch_array($query)) {

        $reportId     = $row['report_id'];
        $orderId      = $row['order_id'];
        $productTitle = $row['product_title'];
        $productPrice = $row['product_price'];
        $productQty   = $row['product_qty'];
        $rawTotal = $productPrice * $productQty;

        $report = <<<PRODUCT
<tr>
    <th>{$reportId}</th>
    <th>{$orderId}</th>
    <th>{$productTitle}</th>
    <th>{$productPrice}</th>
    <th>{$productQty}</th>
    <th>{$rawTotal}</th>
</tr>

PRODUCT;

        echo $report;

    }
}


function displayUsers()
{

    $query = "SELECT * FROM users";

    $query = query($query);

    confirm($query);

    $template_path = TEMPLATES;

    while ($row = fetch_array($query)) {

        $userId    = $row['user_id'];
        $userName  = $row['user_name'];
        $userEmail = $row['user_email'];
        $userFname = $row['user_first_name'];
        $userLname = $row['user_last_name'];
        $userImage = $row['user_image'];

        if (!empty($userImage)) {

            $userImage = pathToImage("backend", $userImage);

        } else {

            $userImage = "http://placehold.it/60x60";
        }

        $users = <<<USER
<tr>
    <th>{$userId}</th>
    <th>{$userName}</th>
    <th><a href="index.php?edit_user&id={$userId}"><img src="{$userImage}" height="60px"></a></th>
    <th>{$userEmail}</th>
    <th>{$userFname}</th>
    <th>{$userLname}</th>
    <th>Edit</th>
    <th><a class="btn btn-danger" href="{$template_path}/back/delete.php?entity=user&id={$userId}"><span class="glyphicon glyphicon-remove"></span></a></th>
</tr>

USER;

        echo $users;

    }

}


function addUser()
{

    if (isset($_POST['add_user'])) {

        $userName             = escape_string($_POST['username']);
        $userEmail       = escape_string($_POST['email']);
        $userFname = escape_string($_POST['first_name']);
        $userLname             = escape_string($_POST['last_name']);
        $userPassword          = escape_string($_POST['password']);

        $userImage       = $_FILES['file']['name'];
        $image_temp_location = $_FILES['file']['tmp_name'];

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $userImage);

        $userImage = escape_string($userImage);

        $query = <<<SQL
INSERT INTO users (user_name
                 , user_email
                 , user_password
                 , user_first_name
                 , user_last_name
                 , user_image
                  ) 
           VALUES ('{$userName}'
                 , '{$userEmail}'
                 , '{$userPassword}'
                 , '{$userFname}'
                 , '{$userLname}'
                 , '{$userImage}'
                  ) 
SQL;

        $query = query($query);
        confirm($query);
        setMessage("success", "User added successfully");
        redirect("index.php?users");
    }

}


function updateUser()
{

    if (isset($_POST['update'])) {

        $user_id                = escape_string($_GET['id']);
        $user_title             = escape_string($_POST['user_title']);
        $user_description       = escape_string($_POST['user_description']);
        $user_short_description = escape_string($_POST['user_short_description']);
        $user_price             = escape_string($_POST['user_price']);
        $user_category          = escape_string($_POST['user_category']);
        $user_quantity          = escape_string($_POST['user_quantity']);
        $user_status            = escape_string($_POST['update']);
        $user_status            = setuserStatus($user_status);

        $user_image       = $_FILES['file']['name'];
        $image_temp_location = $_FILES['file']['tmp_name'];

        if (empty($user_image)) {

            $query = "SELECT user_image FROM users WHERE user_id = $user_id ";

            $query = query($query);

            confirm($query);

            while($row = fetch_array($query)) {

                $user_image = $row['user_image'];

            }

        }



        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $user_image);

        $user_image = escape_string($user_image);

        $query = <<<SQL
UPDATE users SET user_title             = '{$user_title}'
                  , user_category_id       = '{$user_category}'
                  , user_price             = '{$user_price}'
                  , user_quantity          = '{$user_quantity}'
                  , user_description       = '{$user_description}'
                  , user_short_description = '{$user_short_description}'
                  , user_image             = '{$user_image}'
                  , user_status            = '{$user_status}' 
WHERE user_id = {$user_id}
SQL;



        $query = query($query);
        confirm($query);
        setMessage("success", "user updated successfully");
        redirect("index.php?users");
    }

}