<?php


function show_subscriptions() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap">';
    echo '<p>This is the subscriptions page</p>';
    echo '</div>';
}