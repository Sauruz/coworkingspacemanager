<?php

/**
 * Ajax call for calendar
 */
add_action('wp_ajax_csmcalendar', 'csmcalendar');

function csmcalendar() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    $CsmMembership = new CsmMembership();
    /**
     * TODO, start and end don't pick up full months so we go 1 year ahead and bacl
     */
    $memberships = $CsmMembership->all(0, 10000, 'identifier', 'ASC', false, date('Y-m-d', (strtotime($_REQUEST['start']) - (60 * 60 * 24 * 365))), date('Y-m-d', (strtotime($_REQUEST['end']) + (60 * 60 * 24 * 365))));

    $response = array();
    foreach ($memberships as $k => $v) {
        array_push($response, array(
            "title" => show_a_name($v) . ' - ' . $v['workplace_name'] . ' • ' . $v['plan_name'],
            "allDay" => true,
            "start" => $v['plan_start'],
            "end" => $v['plan_end'],
            "backgroundColor" => $v['color'],
            "borderColor" => $v['color'],
            "textColor" => "#fff"
        ));
    }
    wp_send_json($response);
    wp_die();
}

/**
 * Get available membership plans
 */
add_action('wp_ajax_csmmembershipplans', 'csmmembershipplans');

function csmmembershipplans() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    $CsmPlan = new CsmPlan();
    $plans = $CsmPlan->all();

    $response = array();
    foreach ($plans as $plan) {
        array_push($response, array("plan_id" => $plan['plan_id'],
            "plan_name" => $plan['plan_name'],
            "workplace_name" => $plan['workplace_name'],
            "price" => $plan['price'],
            "days" => $plan['days']
        ));
    }
    wp_send_json($response);
    wp_die();
}

/**
 * Get members
 */
add_action('wp_ajax_csmmembers', 'csmmembers');

function csmmembers() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }
    
    $CsmMember= new CsmMember();
    $members = $CsmMember->ajax();
    
    wp_send_json($members);
    wp_die();
}


?>
