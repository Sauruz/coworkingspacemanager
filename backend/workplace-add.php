<?php

/**
 * Show page to add workplace
 */
function show_workplace_add() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    
    $CsmWorkplace = new CsmWorkplace();
    $workplaces = $CsmWorkplace->all();
    
    //Add the member
    if (isset($_POST['action']) && $_POST['action'] === 'addworkplace') {
        $data = $_POST;
        $CsmWorkplace = new CsmWorkplace();
        try {
            $CsmWorkplace->create($_POST);
            csm_set_update('New workplace was added');
            hacky_redirect('csm-workplaces');
        } catch (\Exception $e) {
            csm_error($e->getMessage());
        }
    }
    
    include(CSM_PLUGIN_PATH . 'backend/assets/colors.php');
    include(CSM_PLUGIN_PATH . 'views/backend/workplace-add.view.php');
}
