<?php

if ($_REQUEST['identifier']) {
    $CsmMember = new CsmMember();
    $member = $CsmMember->get($_REQUEST['identifier']);
    if (empty($member)) {
        csm_error('No user found with identifier ' . $_REQUEST['identifier'], true);
    } else {
        $data = $member;
        $MembershipTable = new MembershipTable();
        //Fetch, prepare, sort, and filter our data...
        $MembershipTable->prepare_items();
        csm_get_update();
        
        include(CSM_PLUGIN_PATH . 'views/backend/membership-overview.view.php');
    }
} else {
    csm_error('No identifier specified', true);
}
?>
