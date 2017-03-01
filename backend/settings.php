<?php

function show_settings() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    include(CSM_PLUGIN_PATH . '/backend/assets/currency-symbols.php');
    

   //Edit the settings
    if (isset($_POST['action']) && $_POST['action'] === 'change-settings') {
        update_option('csm-currency', $_POST['currency']);
        
        
        csm_update('Settings updated');
       
    }
    
    include(CSM_PLUGIN_PATH . 'views/backend/settings.view.php');
}

?>