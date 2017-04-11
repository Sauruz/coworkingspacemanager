<?php

$CsmSettings = new CsmSettings();
$data = $CsmSettings->all();

$error = false;
$errorStr = "";


/**
 * Check if user is logged in. If user is logged in redirect to user page
 */
if (!is_user_logged_in()) {
    wp_redirect('?csm=login');
} else {

    $CsmMember = new CsmMember();
    $member = $CsmMember->get(get_current_user_id());
    $update = csm_get_update_frontend();

    /**
     * Log user out
     */
    if (isset($_POST['action']) && $_POST['action'] === 'logout') {
        wp_logout();
        wp_redirect('?csm=login');
        exit;
    }

    //Edit the member
    if (isset($_POST['action']) && $_POST['action'] === 'editmember') {
        $_POST['email'] = $member['email'];
        $member = $_POST;
        $CsmMember = new CsmMember();
        try {
            $CsmMember->update(get_current_user_id(), $member);
            csm_set_update($member['first_name'] . ' ' . $member['last_name'] . ' was updated');
            $update = csm_get_update_frontend();
        } catch (\Exception $e) {
            csm_error($e->getMessage());
        }
    }

    include(CSM_PLUGIN_PATH . 'app/views/frontend/member.view.php');
}
?>
