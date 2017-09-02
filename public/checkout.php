<?php require_once("../resources/config.php") ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php include(TEMPLATE_FRONT . DS . "top_navigation.php") ?>






    <!-- Page Content -->
<div class="container">


<!-- /.row -->

    <div class="row">

        <h1>Checkout</h1>


        <?php displayMessage() ?>

        <form action="">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php cart() ?>

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
                    <td><span class="amount"><?php totals('allItemsQty') ?></span></td>
                </tr>

                <tr class="shipping">
                    <th>Shipping and Handling</th>
                    <td>Free Shipping</td>
                </tr>

                <tr class="order-total">
                    <th>Order Total</th>
                    <td><strong><span class="amount">&#36;<?php totals('total') ?></span></strong></td>
                </tr>

            </tbody>

        </table>

        </div><!-- CART TOTALS-->

    </div>
</div><!--Main Content-->


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
