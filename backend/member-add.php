<?php

/**
 * Show page to add members
 */
function show_member_add() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    //Add the member
    if (isset($_POST['action']) && $_POST['action'] === 'addmember') {
        $data = $_POST;
        $CsmMember = new CsmMember();
        try {
            $CsmMember->create($_POST);
            csm_set_update( $_POST['first_name'] . ' ' . $_POST['last_name'] . ' was added');
            hacky_redirect();
        } catch (\Exception $e) {
            csm_error($e->getMessage());
        }
    }
    
    include(CSM_PLUGIN_PATH . 'views/backend/member-add.view.php');
}
