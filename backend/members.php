<?php

function show_members() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    /**
     * EDIT A MEMBER
     */
    if ($_REQUEST['action'] && $_REQUEST['action'] === 'edit') {
        if ($_REQUEST['identifier']) {
            echo 'edit ' . $_REQUEST['identifier'];
        } else {
            wp_die('No identifier specified.');
        }
    } else
    /**
     * MEMBERS TABLE
     */ {
        //Create an instance of our package class...
        $membersTable = new MembersTable();
        //Fetch, prepare, sort, and filter our data...
        $membersTable->prepare_items();
        include(CSM_PLUGIN_PATH . 'views/backend/members.view.php');
    }
}
