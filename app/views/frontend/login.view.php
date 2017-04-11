<?php include('layout/header.view.php'); ?>

<div class="container">
    <div class="row">
        <div class="panel col-md-4 col-md-offset-4 panel-login">
            <div class="panel-header">
                <h4>Login to <?php echo $data['csm_name']; ?></h4>
            </div>
            <div class="panel-body">
                <form action="" method="POST">
                    <input name="action" type="hidden" value="login">

                    <?php if ($error) { ?>
                        <div class="alert alert-danger"><?php echo $errorStr; ?></div>
                    <?php } ?>

                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="user_login" placeholder="Email"><br>

                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="user_password" placeholder="Password"><br>

                    <input id="remember" type="checkbox" name="remember">
                    <label for="remember">Remember me</label><br><br> 

                    <button type="submit" class="btn btn-block btn-success">Login</button><br>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.view.php'); ?>
                