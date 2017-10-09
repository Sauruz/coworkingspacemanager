<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Dashboard <?php echo $settings['csm_name']; ?></strong></h1>
    <div class="bootstrap-wrapper">

        <div class="row">
            <div class="col-sm-12">
            <h4><span class="label label-info">
                    <?php echo __('Members can login at ', 'csm');?>
                    <a target="_blank" href="<?php echo csm_permalink_url('login');?>"><?php echo csm_permalink_url('login');?></a></span>
            </h4>
            </div>
            </div>

        <h3><?php echo __('Capacity stats', 'csm');?></h3>
        <div class="row">
            <?php foreach($capacity as $k => $v) { ?>
                <div class="col-md-3">
                    <div class="panel">
                        <div class="panel-body text-center">
                            <div class="c100 p<?php echo $v['percentage']; ?>">
                                <span><?php echo $v['percentage']; ?>%</span>
                                <div class="slice">
                                    <div class="bar"></div>
                                    <div class="fill"></div>
                                </div>
                            </div>
                            <br>
                            <h5><?php echo $v['workplace_capacity'] - $v['memberships_count']; ?> of <?php echo $v['workplace_capacity']; ?> desks available</h5>
                            <h4><?php echo $v['workplace_name'];?></h4>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


        <h3><?php echo __('Member stats', 'csm');?></h3>
        <div class="row">
            <div class="col-md-3">
                <div class="panel">
                    <div class="panel-body text-center">
                        <div class="dashboard-circle bg-success"><?php echo $CsmDashboard->countActiveUsers(); ?></div>
                        <h4><?php echo __('Active members', 'csm');?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel">
                    <div class="panel-body text-center">
                        <div class="dashboard-circle"><?php echo $CsmDashboard->countUsers(); ?></div>
                        <h4><?php echo __('Total members', 'csm');?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel">
                    <div class="panel-body text-center">
                        <div class="dashboard-circle bg-warning"><?php echo $CsmDashboard->countPaymentsToReceive(); ?></div>
                        <h4><?php echo __('Payments to receive', 'csm');?></h4>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>