<?php

//helper functions

function redirect($location)
{

    header("Location: $location");

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
                    <h4><a href="item.php?id={$row['product_id']}"><?php echo $row['product_title']?></a>
                    </h4>
                    <p><?php echo $row['product_short_description']?></p>
                    <a class="btn btn-primary" target="_blank" href="item.php?id=<?php echo $row['product_id']?>">Add to cart</a>
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
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id=<?php echo $row['product_id']?>" class="btn btn-default">More Info</a>
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
