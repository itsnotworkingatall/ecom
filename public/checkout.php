<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php include(TEMPLATE_FRONT . DS . "top_navigation.php") ?>






    <!-- Page Content -->
<div class="container">


<!-- /.row -->

    <div class="row">

        <h1>Checkout</h1>
        <h2>
        <?php

            if (isset($_SESSION['product_1'])) {

                echo $_SESSION['product_1'];

            }

        ?>


        </h2>

        <?php displayMessage() ?>

        <form action="">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub-total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>apple</td>
                        <td>$23</td>
                        <td>3</td>
                        <td>2</td>
                        <td><a href="cart.php?remove=1">Remove</a></td>
                        <td><a href="cart.php?add=1">Add</a></td>
                        <td><a href="cart.php?delete=1">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </form>



        <!--  ***********CART TOTALS*************-->

        <div class="col-xs-4 pull-right ">
        <h2>Cart Totals</h2>

        <table class="table table-bordered" cellspacing="0">

            <tbody>

                <tr class="cart-subtotal">
                <th>Items:</th>
                <td><span class="amount">4</span></td>
                </tr>

                <tr class="shipping">
                <th>Shipping and Handling</th>
                <td>Free Shipping</td>
                </tr>

                <tr class="order-total">
                <th>Order Total</th>
                <td><strong><span class="amount">$3444</span></strong> </td>
                </tr>

            </tbody>

        </table>

        </div><!-- CART TOTALS-->

    </div>
</div><!--Main Content-->


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
