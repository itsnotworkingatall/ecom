<div class="col-lg-12">
    <p class="bg-success"><?php // echo $message; ?></p>
    <a href="index.php?add_user" class="btn btn-primary">Add User</a>
</div>

<div class="col-md-12">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Image</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name </th>
            </tr>
        </thead>
        <tbody>
        <?php //foreach($users as $user): ?>
            <tr>
                <?php displayUsers() ?>
            </tr>
        <?php //endforeach; ?>
        </tbody>
    </table> <!--End of Table-->
</div>

