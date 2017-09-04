
<?php

    updateProduct();

    if (isset($_GET['id'])) {

        $productId = escape_string($_GET['id']);

        $query = query("SELECT * FROM products WHERE product_id = {$productId} ");
        confirm($query);

        while ($row = fetch_array($query)) {

            $product_title             = escape_string($row['product_title']);
            $product_description       = escape_string($row['product_description']);
            $product_short_description = escape_string($row['product_short_description']);
            $product_price             = escape_string($row['product_price']);
            $product_category          = escape_string($row['product_category_id']);
            $product_quantity          = escape_string($row['product_quantity']);
            $product_status            = escape_string($row['product_status']);
            $product_status            = getProductStatus($product_status);
            $product_image             = pathToImage("backend", $row['product_image']);

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-8">
        <div class="form-group">
            <label for="product-title">Product Title </label>
            <input type="text" name="product_title" class="form-control" value="<?php echo stripcslashes($product_title) ?>">
        </div>

        <div class="form-group">
            <label for="product-short-description">Short Description</label>
            <textarea name="product_short_description" id="" cols="30" rows="4" class="form-control"><?php echo stripcslashes($product_short_description) ?></textarea>
        </div>

        <div class="form-group">
            <label for="product-description">Description</label>
            <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?php echo stripcslashes($product_description) ?></textarea>
        </div>
        <div class="form-group row">
            <div class="col-xs-3">
                <label for="product-price">Product Price</label>
                <input type="text" name="product_price" class="form-control" size="60" value="<?php echo $product_price ?>">
            </div>
        </div>
    </div><!--Main Content-->
    <!-- SIDEBAR-->
    <aside id="admin_sidebar" class="col-md-4">

        <!-- Product Categories-->
        <div class="form-group">
            <label for="product-title">Product Category</label>

            <select name="product_category" id="" class="form-control">
                <option value="0">--- Select Category ---</option>
                <?php getCategoriesList() ?>
            </select>
        </div>
        <!-- Product Brands-->
        <div class="form-group">
            <label for="product-title">Product Quantity</label>
            <input type="number" name="product_quantity" class="form-control" value="<?php echo $product_quantity ?>">
        </div>
        <!-- Product Tags -->
        <!--        <div class="form-group">-->
        <!--            <label for="product-title">Product Keywords</label>-->
        <!--            <hr>-->
        <!--            <input type="text" name="product_tags" class="form-control">-->
        <!--        </div>-->
        <!-- Product Image -->
        <div><label for="product-title">Product Image</label></div>
        <div>
            <?php if (!$product_image == null) { ?>
                <img src="<?php echo stripcslashes($product_image) ?>" alt="">
            <?php } ?>
        </div>

        <br>

        <div class="form-group">
            <input type="file" name="file">
        </div>

        <div class="form-group">
            <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
            <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
        </div>
    </aside><!--SIDEBAR-->
</form>

<?php

        }
    }

?>

