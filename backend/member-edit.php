<?php

/**
 * Edit a member
 */
function show_member_edit() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    if ($_REQUEST['member_identifier']) {
        $CsmMember = new CsmMember();
        $member = $CsmMember->get($_REQUEST['member_identifier']);
        if (empty($member)) {
            csm_error('No user found with identifier ' . $_REQUEST['member_identifier'], true);
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
            include(CSM_PLUGIN_PATH . 'views/backend/member-edit.view.php');
        }
    } else {
        csm_error('No member identifier specified', true);
    }
}

?>
