<?php

function show_members() {
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    /**
     * EDIT A MEMBER
     */
    if ($_REQUEST['action'] && $_REQUEST['action'] === 'editmember') {
        include(CSM_PLUGIN_PATH . 'backend/member-edit.php');
    } else if ($_REQUEST['action'] && $_REQUEST['action'] === 'add-membership-plan')
    /**
     * NEW MEMBERSHIP
     */ {
        include(CSM_PLUGIN_PATH . 'backend/membership-plan-add.php');
    } else if ($_REQUEST['action'] && $_REQUEST['action'] === 'membership-history')
    /**
     * MEMBERSHIP HISTORY
     */ {
        include(CSM_PLUGIN_PATH . 'backend/membership-history.php');
    } else
    /**
     * MEMBERS TABLE
     */ {
        //Create an instance of our package class...
        $membersTable = new MembersTable();
        //Fetch, prepare, sort, and filter our data...
        $membersTable->prepare_items();
        csm_get_update();
        include(CSM_PLUGIN_PATH . 'views/backend/members.view.php');
    }
}
