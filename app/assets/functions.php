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
 * Get update message for frontend
 * @return string
 */
function csm_get_update_frontend() {
    if (isset($_SESSION['update_message']) && !empty($_SESSION['update_message'])) {
        $update = $_SESSION['update_message'];
        $_SESSION['update_message'] = '';
        return $update;
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

/**
 * 
 * @param type $prefix
 * @param type $id
 * @param type $key
 * @param type $comma
 * @return string
 */
function meta_user_query($prefix, $id, $key, $comma = false, $alias = false) {
    if (!$alias) {
        $alias = $key;
    }
    $response = "(SELECT meta_value FROM " . $prefix . "usermeta WHERE user_id = " . intval($id) . " AND meta_key = '" . $key . "' LIMIT 0,1) AS " . $alias . " ";
    if ($comma) {
        $response .= ", ";
    }
    return $response;
}

/**
 * Show first and last name or display name
 * @param type $data
 * @return type
 */
function show_a_name($data) {
    if (!empty($data['first_name']) && !empty($data['last_name'])) {
        return $data['first_name'] . ' ' . $data['last_name'];
    } else {
        return $data['display_name'];
    }
}

/**
 * Create a random password
 * @return type
 */
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 * Active a navbar item
 * @param type $currentSlug
 * @param type $activeSlug
 */
function activeSlug($currentSlug, $activeSlug) {
    echo $currentSlug === $activeSlug ? "active" : "";
}

/**
 * Prints content in plain text then dies
 * @param type $content
 */
function print_p($content) {
    header('Content-Type: text/plain');
    print_r($content);
    die;
}

/**
 * Show a membership status column
 * @param type $item
 * @return string
 */
function column_membership_status($item) {
    if ((strtotime($item['plan_start']) <= time()) && (strtotime($item['plan_end']) > time())) {
        return '<span class="label label-success label-member-active">Active</span>';
    } else if ((strtotime($item['plan_start']) > time()) && (strtotime($item['plan_end']) > time())) {
        return '<span class="label label-info label-member-active">Upcoming</span>';
    } else {
        return '<span class="label label-default label-member-active" style="display:block">Inactive</span>';
    }
}

/**
 * Show column of plan
 * @param type $item
 * @return string
 */
function column_plan($item) {
    print_r($item);
    if ($item['plan']) {
        return '<strong><i class="fa fa-fw fa-clock-o text-success" aria-hidden="true"></i> ' . $item['plan'] . '<br><i class="fa fa-fw fa-desktop text-success" aria-hidden="true"></i> ' . $item['workplace'] . '</strong>';
    } else {
        return '';
    }
}

?>
