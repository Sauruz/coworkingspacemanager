<?php

/**
 * Show form to add a membership plan
 */
function show_member_membership_add() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    if ($_REQUEST['member_identifier']) {
        $CsmMember = new CsmMember();
        $member = $CsmMember->get($_REQUEST['member_identifier']);
        if (empty($member)) {
            csm_error('No user found with identifier ' . $_REQUEST['member_identifier'], true);
        } else {
            $data = $member;

            //This is used in the template, do not remove
            $CsmPlan = new CsmPlan();
            $plans = $CsmPlan->all();

            //die;
            //Add membership plan
            if (isset($_POST['action']) && $_POST['action'] === 'add-membership-plan') {
                $data = $_POST;

                try {
                    $CsmMembership = new CsmMembership();
                    $CsmMembership->create_simple(array(
                        'member_identifier' => $_REQUEST['member_identifier'],
                        'plan_id' => $_POST['plan_id'],
                        'plan_start' => $_POST['plan_start'],
                        'vat' => $_POST['vat']
                    ));

                    csm_set_update('Membership plan added');
                    hacky_redirect('csm-member-memberships&member_identifier=' . $_REQUEST['member_identifier']);
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
            include(CSM_PLUGIN_PATH . 'app/views/member-membership-add.view.php');
        }
    } else {
        csm_error('No member identifier specified', true);
    }
}

?>
