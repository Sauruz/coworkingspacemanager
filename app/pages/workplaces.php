<?php
/**
 * Show table with workplaces
 */
function show_workplaces() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    //Check if settings are set
    if (!CSM_SETTINGS_SET) {
        csm_error("Please enter your coworking space details at settings in the left menu");
    }
    
    //Create an instance of our package class...
    $workplacesTable = new WorkplacesTable();
    //Fetch, prepare, sort, and filter our data...
    $workplacesTable->prepare_items();
    csm_get_update();
    
    include(CSM_PLUGIN_PATH . 'app/views/workplaces.view.php');
}
?>
