<?php include('layout/header.view.php'); ?>
<?php include('layout/navbar.view.php'); ?>

<div class="container">
    <div class="row">
        <div class="panel col-md-6 col-md-offset-3">
            <div class="panel-body">

                <?php if (!empty($update)) { ?>
                    <div class="alert alert-success"><?php echo $update; ?></div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-4 col-md-offset-4 text-center">
                        <img class="avatar-big" src="<?php echo get_avatar_url($member['id']); ?>">
                        <p><br>You can change your profile picture on <a href="https://en.gravatar.com/">Gravatar</a>.</p>
                        <hr>
                    </div>
                </div>

                <form action="" method="post">
                    <input name="action" type="hidden" value="editmember">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="first_name">First Name <span class="description">(required)</span></label><br>
                            <input name="first_name" class="form-control" placeholder="First Name" type="text" id="first_name" value="<?php form_value($member, 'first_name'); ?>"><br>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name">Last Name <span class="description">(required)</span></label><br>
                            <input name="last_name" class="form-control" placeholder="Last Name"  type="text" id="last_name" value="<?php form_value($member, 'last_name'); ?>"><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="email">Email</label><br>
                            <div class="form-control-static"><?php form_value($member, 'email'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="company">Company</label><br>
                            <input name="company" class="form-control" type="text" placeholder="Company" id="company" value="<?php form_value($member, 'company'); ?>"><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="address">Address</label><br>
                            <input name="address" class="form-control" type="text" placeholder="Address" id="address" value="<?php form_value($member, 'address'); ?>"><br>
                        </div>
                        <div class="col-md-6">
                            <label for="locality">City, State/Province</label><br>
                            <input name="locality" class="form-control" type="text" placeholder="City, State/Province" id="locality" value="<?php form_value($member, 'locality'); ?>"><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="country">Country</label><br>
                            <input name="country" class="form-control" type="text" placeholder="Country" id="country" value="<?php form_value($member, 'country'); ?>"><br>
                        </div>
                        <div class="col-md-6">
                            <label for="profession">Profession</label><br>
                            <input name="profession" class="form-control" type="text" placeholder="Profession" id="profession" value="<?php form_value($member, 'profession'); ?>"><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="bio">Bio</label><br>
                            <textarea name="bio" class="form-control" id="bio" placeholder="Enter a short description" rows="6"><?php form_value($member, 'bio'); ?></textarea><br>
                        </div>
                    </div>
                    <p class="submit">
                        <input type="submit" name="createuser" id="createusersub" class="btn btn-success btn-block" value="Save">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.view.php'); ?>
                