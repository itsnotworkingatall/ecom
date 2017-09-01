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

    while ($row = fetch_array($query)) {

        $product = <<<CUT

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>{$row['product_description']}</p>
            <a class="btn btn-primary" target="_blank" href="item.php?id={$row['product_id']}">Add to cart</a>
        </div>
    </div>
</div>

CUT;
        echo $product;

    }
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
