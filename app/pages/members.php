<?php

/**
 * Show members page
 */
function show_members() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    //Check if settings are set
    if (!CSM_SETTINGS_SET) {
        csm_error("Please enter your coworking space details under `Settings` in the left menu");
    }

    $csm_permalink= new csm_permalink();

    //Create an instance of our package class...
    $membersTable = new MembersTable();
    //Fetch, prepare, sort, and filter our data...
    $membersTable->prepare_items();
    csm_get_update();
    include(CSM_PLUGIN_PATH . 'app/views/members.view.php');
}
