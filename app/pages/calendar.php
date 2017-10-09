<?php
/**
 * Show calendar
 */
function show_calendar() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    //Check if settings are set
    if (!CSM_SETTINGS_SET) {
        csm_error("Please enter your coworking space details at settings in the left menu.");
    }
    
   
    include(CSM_PLUGIN_PATH . 'app/views/calendar.view.php');
}

?>
