<?php

/**
 * Show page to add members
 */
function show_member_add() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    //Add the member
    if (isset($_POST['action']) && $_POST['action'] === 'addmember') {
        $CsmMember = new CsmMember;
        try {
            $CsmMember->create($_POST);
            echo '<div class="updated"><p><strong>Member was added</strong></p></div>';
        } catch (\Exception $e) {
            echo '<div class="error"><p><strong>' . $e->getMessage() . '</strong></p></div>';
        }
    }
    
    include(CSM_PLUGIN_PATH . 'views/backend/member-add.view.php');
}
