<?php

/**
 * Show plans table
 */
function show_plans() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    //Create an instance of our package class...
    $plansTable = new PlansTable();
    //Fetch, prepare, sort, and filter our data...
    $plansTable->prepare_items();
    csm_get_update();
    
    include(CSM_PLUGIN_PATH . 'app/views/plans.view.php');
}
?>
