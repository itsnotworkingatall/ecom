<div class="row carousel-holder">

    <div class="col-md-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">

                <?php sliderNavigation() ?>

            </ol>

            <div class="carousel-inner">

                <?php getSlides() ?>

            </div>

            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>

</div>
