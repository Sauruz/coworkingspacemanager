<?php

/**
 * Edit general settings of Coworking Space Manager
 */
function show_settings() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    $CsmSettings = new CsmSettings();
    $data = $CsmSettings->all();

    include(CSM_PLUGIN_PATH . '/app/assets/currency-symbols.php');

    //Edit the settings
    if (isset($_POST['action']) && $_POST['action'] === 'change-settings') {
        $data = $_POST;
        foreach($data as $k => $v) {
           $data[$k] =  stripslashes($v);
        }
       
        try {
            $CsmSettings->update($data);
            csm_update('Settings updated');
        } catch (\Exception $e) {
            csm_error($e->getMessage());
        }
    }

    include(CSM_PLUGIN_PATH . 'app/views/settings.view.php');
}

?>