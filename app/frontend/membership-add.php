<?php

$CsmSettings = new CsmSettings();
$data = $CsmSettings->all();

$error = false;
$errorStr = "";

$currentSlug = "memberships";

/**
 * Check if user is logged in. If user is logged in redirect to user page
 */
if (!is_user_logged_in()) {
    wp_redirect('?csm=login');
} else {
    
    $CsmMember = new CsmMember();
    $member = $CsmMember->get(get_current_user_id());

    $CsmMembership = new CsmMembership();
    $memberships = $CsmMembership->all(0, 10000, 'identifier', 'DESC', get_current_user_id());
    $update = csm_get_update_frontend();
    
    //Add membership plan
    if (isset($_POST['action']) && $_POST['action'] === 'member-membership-add') {
        $data = $_POST;

        try {
            $CsmMembership = new CsmMembership();
            $CsmMembership->create_simple(array(
                'user_id' => get_current_user_id(),
                'plan_id' => $_POST['plan_id'],
                'plan_start' => $_POST['plan_start'],
                'approved' => 1,
                'vat' => 0
            ));

            csm_set_update('Membership plan added');
            wp_redirect('?csm=memberships');
        } catch (\Exception $e) {
            csm_error($e->getMessage());
        }
    }
    
    include(CSM_PLUGIN_PATH . 'app/views/frontend/membership-add.view.php');
}
?>
