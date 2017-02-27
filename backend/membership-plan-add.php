<?php

if ($_REQUEST['identifier']) {
    $CsmMember = new CsmMember();
    $member = $CsmMember->get($_REQUEST['identifier']);
    if (empty($member)) {
        csm_error('No user found with identifier ' . $_REQUEST['identifier'], true);
    } else {
        $data = $member;

//        $CsmMembership = new CsmMemberShip();
//
//        try {
//            $response = $CsmMembership->create(array(
//                'member_identifier' => $_REQUEST['identifier'],
//                'plan' => 'Month',
//                'plan_start' => '2017-02-20',
//                'plan_end' => '2017-03-20',
//                'price' => 100,
//                'vat' => 0,
//                'price_total' => 100
//            ));
//            if ($response !== 1) {
//                csm_error('Something went wrong');
//            }
//        } catch (\Exception $e) {
//            csm_error($e->getMessage());
//        }
        
        $CsmPlan = new CsmPlan();
        
        $CsmPlan->create(array(
            'name' => 'Day',
            'price' => 10,
            'days' => 1,
        ));
        
        
        //Edit the member
        if (isset($_POST['action']) && $_POST['action'] === 'editmember') {
            $data = $_POST;
            $CsmMember = new CsmMember();
            try {
                $CsmMember->update($member['identifier'], $_POST);
                csm_set_update($_POST['first_name'] . ' ' . $_POST['last_name'] . ' was updated');
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
