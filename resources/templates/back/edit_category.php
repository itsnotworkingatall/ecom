
<?php

updateCategory();

if (isset($_GET['id'])) {

    $categoryId = escape_string($_GET['id']);

    $query = query("SELECT * FROM categories WHERE cat_id = {$categoryId} ");
    confirm($query);

    while ($row = fetch_array($query)) {

        $categoryTitle = escape_string($row['cat_title']);

        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-8">
                <label for="category-title">Category Title </label>
                <div class="input-group">
                    <input type="text" name="category_title" class="form-control" value="<?php echo stripcslashes($categoryTitle) ?>">
                    <span class="input-group-btn"><input type="submit" name="update" class="btn btn-primary btn-md" value="Update"></span>
                </div>
            </div><!--Main Content-->
        </form>

        <?php

    }
}

?>

