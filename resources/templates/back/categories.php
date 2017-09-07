<?php addCategory() ?>


<div class="col-md-4">
    <form action="" method="post">
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" name="category_title" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="addcategory" class="btn btn-primary" value="Add Category">
        </div>
    </form>
</div>
<div class="col-md-8">
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>Title</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

                <?php getCategories(true) ?>

        </tbody>
    </table>
</div>

<!-- /.container-fluid -->
