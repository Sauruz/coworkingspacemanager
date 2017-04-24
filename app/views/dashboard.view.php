<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Dashboard <?php echo $settings['csm_name']; ?></strong></h1>

    <div class="bootstrap-wrapper">
        <h3>Capacity stats</h3>
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


        <h3>Member stats</h3>
        <div class="row">
            <div class="col-md-3">
                <div class="panel">
                    <div class="panel-body text-center">
                        <div class="dashboard-circle bg-success"><?php echo $CsmDashboard->countActiveUsers(); ?></div>
                        <h4>Active members</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel">
                    <div class="panel-body text-center">
                        <div class="dashboard-circle"><?php echo $CsmDashboard->countUsers(); ?></div>
                        <h4>Total members</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel">
                    <div class="panel-body text-center">
                        <div class="dashboard-circle bg-warning"><?php echo $CsmDashboard->countPaymentsToReceive(); ?></div>
                        <h4>Payments to receive</h4>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>