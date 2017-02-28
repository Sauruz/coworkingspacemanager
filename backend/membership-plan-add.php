<?php

if ($_REQUEST['identifier']) {
    $CsmMember = new CsmMember();
    $member = $CsmMember->get($_REQUEST['identifier']);
    if (empty($member)) {
        csm_error('No user found with identifier ' . $_REQUEST['identifier'], true);
    } else {
        $data = $member;

        //This is used in the template, do not remove
        $CsmPlan = new CsmPlan();
        $plans = $CsmPlan->all();


        //Add membership plan
        if (isset($_POST['action']) && $_POST['action'] === 'add-membership-plan') {
            $data = $_POST;

            try {
                $CsmMembership = new CsmMembership();
                $CsmMembership->create_simple(array(
                    'member_identifier' => $_REQUEST['identifier'],
                    'plan_id' => $_POST['plan_id'],
                    'plan_start' => $_POST['plan_start'],
                    'vat' => $_POST['vat']
                ));

                csm_set_update('Membership plan added');
                hacky_redirect();
            } catch (\Exception $e) {
                csm_error($e->getMessage());
            }
        }
        include(CSM_PLUGIN_PATH . 'views/backend/membership-plan-add.view.php');
    }
} else {
    csm_error('No identifier specified', true);
}
?>
