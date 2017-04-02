<?php

/**
 * Edit a member
 */
function show_member_profile() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    if ($_REQUEST['id']) {
        $CsmMember = new CsmMember();
        $member = $CsmMember->get($_REQUEST['id']);
        if (empty($member)) {
            csm_error('No user found with id ' . $_REQUEST['id'], true);
        } else {
            $data = $member;

            //Edit the member
            if (isset($_POST['action']) && $_POST['action'] === 'editmember') {
                $data = $_POST;
                $CsmMember = new CsmMember();
                try {
                    $CsmMember->update($member['identifier'], $_POST);
                    csm_set_update($_POST['first_name'] . ' ' . $_POST['last_name'] . ' was updated');
                    hacky_redirect();
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
            include(CSM_PLUGIN_PATH . 'app/views/member-profile.view.php');
        }
    } else {
        csm_error('No member identifier specified', true);
    }
}

?>
