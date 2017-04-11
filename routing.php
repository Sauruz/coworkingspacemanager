<?php


add_action('init', 'cms_flush_rewrite_rules');

/**
 * Rewrite
 */
add_action('init', 'csm_rewrite_rules');
function csm_rewrite_rules() {
    add_rewrite_rule( 'csm/([^/]*)/?', 'index.php?csm=$matches[1]', 'top' );
}

/**
 *  Query Vars 
 */
add_filter( 'query_vars', 'csm_register_query_var' );
function csm_register_query_var( $vars ) {
    $vars[] = 'csm';
    return $vars;
}

/** 
 * Template Include 
 */
add_filter('template_include', 'csm_login_template_include', 1, 1); 
function csm_login_template_include($template)
{
    global $wp_query; 
    $page_value = $wp_query->query_vars['csm']; 

    if ($page_value && $page_value == "login") { 
        return plugin_dir_path(__FILE__).'app/frontend/login.php'; 
    }
    if ($page_value && $page_value == "member") { 
        return plugin_dir_path(__FILE__).'app/frontend/member.php'; 
    }
    
    return $template;
}
?>
