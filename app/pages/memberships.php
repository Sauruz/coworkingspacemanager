<?php

/**
 * Show overview of membership plans 
 */
function show_memberships() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

        //Update payment status
        if (isset($_POST['action']) && $_POST['action'] === 'addpayment') {
            $CsmMember = new CsmMember();
            $CsmMembership = new CsmMembership();
            try {
                $CsmMembership->payment($_POST['identifier'], $_POST);
                csm_set_update('Payment status of ' . $_POST['identifier'] . ' has been updated');
            } catch (Exception $e) {
                csm_error($e->getMessage());
            }
        };

        $data = $member;
        $MembershipTable = new MembershipTable();
        //Fetch, prepare, sort, and filter our data...
        $MembershipTable->prepare_items();
        csm_get_update();

        include(CSM_PLUGIN_PATH . 'app/views/memberships.view.php');

}

?>
