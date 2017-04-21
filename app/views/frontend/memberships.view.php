<?php include('layout/header.view.php'); ?>
<?php include('layout/navbar.view.php'); ?>

<div class="container">
    <div class="row">
        <div class="panel col-md-12">
            <div class="panel-body">

                <?php include('tabbar/memberships.tabbar.php'); ?>

                <?php if (!empty($update)) { ?>
                    <div class="alert alert-success"><?php echo $update; ?></div>
                <?php } ?>

                <table class="table table-striped table-vertical">
                    <thead>
                    <th>Membership Nr.</th>
                    <th>Status</th>
                    <th>Plan</th>
                    <th>Starts</th>
                    <th>Expires</th>
                    <th>Price</th>
                    <th>Payment Status</th>
                    <th>Invoice</th>
                    </thead>
                    <tbody>
                        <?php foreach ($memberships as $k => $v) { ?>
                            <tr>
                                <td><?php echo $v['identifier']; ?></td>
                                <td><?php echo column_membership_status($v); ?></td>
                                <td><strong><i class="fa fa-fw fa-clock-o text-success" aria-hidden="true"></i><?php echo $v['plan_name']; ?><br><i class="fa fa-fw fa-desktop text-success" aria-hidden="true"></i><?php echo $v['workplace_name']; ?></strong></td>
                                <td><span ng-bind="<?php echo (strtotime($v['plan_start']) * 1000); ?> | date : 'mediumDate'"></span></td>
                                <td><span ng-bind="<?php echo (strtotime($v['plan_end']) * 1000); ?> | date : 'mediumDate'"></span></td>
                                <td><span ng-bind="<?php echo $v['price_total'] . ' | currency : \'' . CSM_CURRENCY_SYMBOL . '\'">' . CSM_CURRENCY_SYMBOL . $item['price_total']; ?>"></span></td>
                                <td><?php echo $v['payment'] === '1' ? '<i class="fa fa-fw fa-lg fa-check-circle text-success" aria-hidden="true"></i> Paid' : '<i class="fa fa-fw fa-lg fa-exclamation-triangle text-warning" aria-hidden="true"></i> Not paid yet'; ?></td>
                                <td><button class="btn btn-default">Download invoice</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.view.php'); ?>
                