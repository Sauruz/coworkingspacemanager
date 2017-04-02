<?php

/**
 * Set a default form value
 * @param type $val
 */
function form_value($data, $val) {
    if (is_object($data)) {
        $res = !empty($data->$val) ? $data->$val : "";
    } else {
        $res = !empty($data[$val]) ? $data[$val] : "";
    }
    echo $res;
}

/**
 * Default error
 * @param type $err
 */
function csm_error($err, $die = false) {
    if ($die) {
        wp_die(__('<div class="error"><p><strong>' . $err . '</strong></p></div>'));
    } else {
        echo '<div class="error"><p><strong>' . $err . '</strong></p></div>';
    }
}

/**
 * Update message
 * @param type $mes
 */
function csm_update($mes) {
    echo '<div class="updated"><p><strong>' . $mes . '</strong></p></div>';
}

/**
 * Set update message with session
 * @param type $mes
 */
function csm_set_update($mes) {
    $_SESSION['update_message'] = $mes;
}

/**
 * Get update message from session
 */
function csm_get_update() {
    if (isset($_SESSION['update_message']) && !empty($_SESSION['update_message'])) {
        csm_update($_SESSION['update_message']);
        $_SESSION['update_message'] = '';
    }
}

/**
 * Hacky AF but whatever, this is Wordpress and wp_redirect gives a bug.
 */
function hacky_redirect($page = false) {
    if ($page) {
        echo'<script> window.location="admin.php?page=' . $page . '"; </script> ';
    } else {
        echo'<script> window.location="admin.php?page=' . PLUGIN_SLUG . '"; </script> ';
    }
}

/**
 * Echo active tab in tabbar
 * @param type $slug
 */
function tab_active($slug) {
    echo!empty($_GET['page']) && $_GET['page'] === $slug ? 'active' : '';
}

?>
