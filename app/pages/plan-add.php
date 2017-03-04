<?php

/**
 * Show page to add plan
 */
function show_plan_add() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    $CsmWorkplace = new CsmWorkplace();
    $workplaces = $CsmWorkplace->all();
    
    //Add the member
    if (isset($_POST['action']) && $_POST['action'] === 'addplan') {
        $data = $_POST;
        $Csmplan = new CsmPlan();
        try {
            $Csmplan->create($_POST);
            csm_set_update('New membership plan was added');
            hacky_redirect('csm-plans');
        } catch (\Exception $e) {
            csm_error($e->getMessage());
        }
    }
    
    include(CSM_PLUGIN_PATH . 'app/views/plan-add.view.php');
}
