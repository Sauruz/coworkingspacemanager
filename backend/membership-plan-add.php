<?php

if ($_REQUEST['identifier']) {
    $CsmMember = new CsmMember();
    $member = $CsmMember->get($_REQUEST['identifier']);
    if (empty($member)) {
        csm_error('No user found with identifier ' . $_REQUEST['identifier'], true);
    } else {
        $data = $member;

        $CsmPlan = new CsmPlan();
        $plans = $CsmPlan->all();


        //Add membership plan
        if (isset($_POST['action']) && $_POST['action'] === 'add-membership-plan') {
            $data = $_POST;

            $plan = $CsmPlan->get($_POST['plan_id']);
            if (empty($plan)) {
                csm_error('Something went wrong. Membership plan does not exist');
            } else {
                $CsmMembership = new CsmMemberShip();

                try {
                    $response = $CsmMembership->create(array(
                        'member_identifier' => $_REQUEST['identifier'],
                        'plan_id' => $_POST['plan_id'],
                        'plan_start' => '2017-02-20',
                        'plan_end' => '2017-03-20',
                        'price' => $plan['price'],
                        'vat' => 0,
                        'price_total' => $plan['price']
                    ));
                    if ($response !== 1) {
                        csm_error('Something went wrong');
                    }
                    else {
                        csm_set_update('Membership plan added');
                        hacky_redirect();
                    }
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
        }
        include(CSM_PLUGIN_PATH . 'views/backend/membership-plan-add.view.php');
    }
} else {
    csm_error('No identifier specified', true);
}
?>
