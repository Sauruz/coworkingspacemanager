<?php

/**
 * Show Dashboard page
 */
function show_dashboard() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    //Check if settings are set
    if (!CSM_SETTINGS_SET) {
        csm_error("Please enter your coworking space details under `Settings` in the left menu");
    }

    $CsmSettings = new CsmSettings();
    $settings = $CsmSettings->all();

    $CsmDashboard = new CsmDashboard();
    $capacity = $CsmDashboard->capacity();

    csm_get_update();
    include(CSM_PLUGIN_PATH . 'app/views/dashboard.view.php');
}



?>