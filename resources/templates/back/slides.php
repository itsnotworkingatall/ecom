<?php addSlides() ?>

<div class="row">
<h3 class="bg-success"></h3>

    <div class="col-xs-3">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <input type="file" name="file">
            </div>

            <div class="form-group">
                <label for="title">Slide Title</label>
                <input type="text" name="slide_title" class="form-control">
            </div>

            <div class="form-group">
                <label for="order">Slide Order</label>
                <input type="number" name="slide_order" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" name="add_slide" class="btn btn-primary">
            </div>
        </form>
    </div>


    <div class="col-xs-8">



    </div>

</div><!-- ROW-->

<hr>
<h1>Slides Available</h1>

<div class="row">
    <div class="col-xs-4">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Sort</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php displaySlidesGrid() ?>
        </tbody>
    </table>
    </div>

</div>


