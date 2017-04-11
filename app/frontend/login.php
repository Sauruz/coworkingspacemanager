<?php

$CsmSettings = new CsmSettings();
$data = $CsmSettings->all();
$error = false;
$errorStr = "";

/**
 * Check if user is logged in. If user is logged in redirect to member page
 */
if (is_user_logged_in()) {
    wp_redirect('?csm=member');
    exit;
}

/**
 * Check if post is done to login
 */
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    //Make sure old user is logged out
    wp_logout();
    
    $credentials = $_POST;
    if (isset($credentials['remember'])) {
        $credentials['remember'] = true;
    }

    $login = wp_signon($credentials);
    if (isset($login->errors)) {
        $error = true;
        foreach ($login->errors as $k => $v) {
            $errorStr .= $v[0] . '<br>';
        }
    } else {
        wp_redirect('?csm=member');
    }
}


include(CSM_PLUGIN_PATH . 'app/views/frontend/login.view.php');
?>