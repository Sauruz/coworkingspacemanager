<?php
/**
 * Show calendar
 */
function show_calendar() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
   
    include(CSM_PLUGIN_PATH . 'views/backend/calendar.view.php');
}

?>
