<?php

/**
 * Show overview of membership plans
 */
function show_membership_overview() {
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
            $MembershipTable = new MembershipTable();
            //Fetch, prepare, sort, and filter our data...
            $MembershipTable->prepare_items();
            csm_get_update();

            include(CSM_PLUGIN_PATH . 'views/backend/membership-overview.view.php');
        }
    } else {
        csm_error('No member identifier specified', true);
    }
}

?>
