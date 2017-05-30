<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <?php if (!empty($data['csm_logo'])) { ?>
                    <img src="<?php echo $data['csm_logo'];?>" class="coworking-navbar-logo">
                <?php } else {
                    echo $data['csm_name']; 
                }?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="<?php activeSlug($currentSlug, "member");?>"><a href="<?php echo csm_permalink_url('member'); ?>"><?php echo show_a_name($member); ?></a></li>
                <li class="<?php activeSlug($currentSlug, "memberships");?>"><a href="<?php echo csm_permalink_url('memberships');?>">Membership Plans</a></li>
            </ul>

            <form class="navbar-form navbar-right" action="" method="POST">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div><!--/.nav-collapse -->
    </div>
</nav>