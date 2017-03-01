<?php

function show_workplaces() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    //Create an instance of our package class...
    $workplacesTable = new WorkplacesTable();
    //Fetch, prepare, sort, and filter our data...
    $workplacesTable->prepare_items();
    csm_get_update();
    
    include(CSM_PLUGIN_PATH . 'views/backend/workplaces.view.php');
}
?>
