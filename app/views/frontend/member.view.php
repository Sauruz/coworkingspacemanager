<?php include('layout/header.view.php'); ?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo $data['csm_name']; ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="active"><a href="?csm=member">About Me</a></li>
                <li><a href="#about">Memberships</a></li>
            </ul>

            <form class="navbar-form navbar-right" action="" method="POST">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="panel col-md-6 col-md-offset-3">
            <div class="panel-body">
                
                <?php if(!empty($update)) {?>
                <div class="alert alert-success"><?php echo $update;?></div>
                <?php } ?>
                
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
                