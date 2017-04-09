<?php

/**
 * Show form to add a membership plan
 */
function show_membership_add() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    //This is used in the template, do not remove
    $CsmPlan = new CsmPlan();
    $plans = $CsmPlan->all();
    

    //Add membership plan
    if (isset($_POST['action']) && $_POST['action'] === 'membership-add') {

        try {
            $CsmMembership = new CsmMembership();
            $CsmMembership->create_simple(array(
                'user_id' => $_POST['user_id'],
                'plan_id' => $_POST['plan_id'],
                'plan_start' => $_POST['plan_start'],
                'vat' => $_POST['vat']
            ));

            csm_set_update('Membership added');
            hacky_redirect('csm-memberships');
        } catch (\Exception $e) {
            csm_error($e->getMessage());
        }
    }
    include(CSM_PLUGIN_PATH . 'app/views/membership-add.view.php');
}

?>
