<?php

/**
 * Ajax call for calendar
 */
add_action('wp_ajax_calendar', 'calendar');

function calendar() {
    $CsmMembership = new CsmMembership();
    /**
     * TODO, start and end don't pick up full months so we go 1 year ahead and bacl
     */
    $memberships = $CsmMembership->all(0, 10000, 'identifier', 'ASC', false, date('Y-m-d', (strtotime($_REQUEST['start']) - (60 * 60 * 24 * 365))), date('Y-m-d', (strtotime($_REQUEST['end']) + (60 * 60 * 24 * 365))));

    $response = array();
    foreach ($memberships as $k => $v) {
        array_push($response, array(
            "title" => $v['first_name'] . ' ' . $v['last_name'] . ' - ' . $v['workplace_name'] . ' • ' . $v['plan_name'],
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

?>
