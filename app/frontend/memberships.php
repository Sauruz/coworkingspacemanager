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

    $CsmMembership = new CsmMembership();
    $memberships = $CsmMembership->all(0, 10000, 'identifier', 'DESC', get_current_user_id());
    $update = csm_get_update_frontend();
    
//    print_p($memberships);

    include(CSM_PLUGIN_PATH . 'app/views/frontend/memberships.view.php');
}
?>
