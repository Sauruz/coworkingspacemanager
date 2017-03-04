<?php

global $csm_db_version;
$csm_db_version = '1.0';
define('PLUGIN_SLUG', 'coworking-space-manager');
define('CMS_LOCALE', str_replace('_', '-', strtolower(get_locale())));
define('CMS_SIMPLE_LOCALE', end(explode('-', CMS_LOCALE)));


/*
  Plugin Name: Coworking Space Manager
  Plugin URI:  http://www.de-rus.nl
  Description: A Wordpress plugin for coworking spaces. Manage members, bookings and invoices.
  Version:     1.0
  Author:      Guido Rus
  Author URI:  http://www.de-rus.nl
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

function register_session() {
    if (!session_id()) {
        session_start();
    }
}

//Tables
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

define('CSM_PLUGIN_PATH', plugin_dir_path(__FILE__));

//Styles & javascript
function csm_style() {
    wp_register_style('csm_style', plugins_url('dist/css/styles.css', __FILE__));
    wp_enqueue_style('csm_style');
    wp_register_script('csm_js', plugins_url('dist/js/app.js', __FILE__));
    wp_enqueue_script('csm_js');
    wp_register_script('i18n', plugins_url('dist/js/i18n/angular-locale_' . CMS_LOCALE . '.js', __FILE__));
    wp_enqueue_script('i18n');
    wp_register_script('calendar-locale', plugins_url('dist/js/calendar-locale/' . CMS_SIMPLE_LOCALE . '.js', __FILE__));
    wp_enqueue_script('calendar-locale');
}
add_action('admin_init', 'csm_style');


//Autoload composer file
require CSM_PLUGIN_PATH . 'vendor/autoload.php';

//Assets
include(CSM_PLUGIN_PATH . '/app/assets/currency-symbols.php');

//Standard CSM Settings Settings
define('CSM_CURRENCY', get_option('csm-currency'));
define('CSM_CURRENCY_SYMBOL', html_entity_decode($currency_symbols[CSM_CURRENCY]));

//Functions
include(CSM_PLUGIN_PATH . 'app/assets/functions.php');

//Models
include(CSM_PLUGIN_PATH . 'app/models/member.model.php');
include(CSM_PLUGIN_PATH . 'app/models/membership.model.php');
include(CSM_PLUGIN_PATH . 'app/models/plan.model.php');
include(CSM_PLUGIN_PATH . 'app/models/workplace.model.php');

//Install
include(CSM_PLUGIN_PATH . 'install/database.php');

//Classes
include(CSM_PLUGIN_PATH . 'app/tables/members-table.php');
include(CSM_PLUGIN_PATH . 'app/tables/membership-table.php');
include(CSM_PLUGIN_PATH . 'app/tables/plans-table.php');
include(CSM_PLUGIN_PATH . 'app/tables/workplaces-table.php');

//Pages
include(CSM_PLUGIN_PATH . 'app/pages/members.php');
include(CSM_PLUGIN_PATH . 'app/pages/member-add.php');
include(CSM_PLUGIN_PATH . 'app/pages/membership-overview.php');
include(CSM_PLUGIN_PATH . 'app/pages/membership-add.php');
include(CSM_PLUGIN_PATH . 'app/pages/profile.php');
include(CSM_PLUGIN_PATH . 'app/pages/settings.php');
include(CSM_PLUGIN_PATH . 'app/pages/plans.php');
include(CSM_PLUGIN_PATH . 'app/pages/plan-add.php');
include(CSM_PLUGIN_PATH . 'app/pages/plan-edit.php');
include(CSM_PLUGIN_PATH . 'app/pages/workplaces.php');
include(CSM_PLUGIN_PATH . 'app/pages/workplace-add.php');
include(CSM_PLUGIN_PATH . 'app/pages/workplace-edit.php');
include(CSM_PLUGIN_PATH . 'app/pages/calendar.php');

//Ajax
include(CSM_PLUGIN_PATH . 'app/assets/ajax.php');

add_action('init', 'register_session');

register_activation_hook(__FILE__, 'create_csm_tables');
register_activation_hook(__FILE__, 'dummy_data');
register_activation_hook(__FILE__, 'default_options');



//Add menu to admin
add_action('admin_menu', 'csm_menu');

function csm_menu() {
    
    add_menu_page('Coworking Space Manager', 'Coworking Space', 'manage_options', PLUGIN_SLUG, 'show_members', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSI2MDBweCIgaGVpZ2h0PSI2MDBweCIgdmlld0JveD0iMCAwIDYwMCA2MDAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDYwMCA2MDAiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxwYXRoIGZpbGw9IiNGMjhBMDAiIGQ9Ik0yOTguNzk4LDIwNy4wNjFjMy41MzUsMC4wMTcsNS4xNzctMC43Myw1LjE1My00Ljc3MmMtMC4xNi0yNi4wOTgtMC4xNTItNTIuMTk5LTAuMDE0LTc4LjI5N2MwLjAyMS0zLjg3OC0xLjM0My00Ljg5OS01LjAyOS00Ljg5MmMtNDUuMzcxLDAuMDk4LTkwLjc0MywwLjExMi0xMzYuMTEzLTAuMDExYy00LjA2Mi0wLjAxLTUuMTU4LDEuMzMyLTUuMTM2LDUuMjVjMC4xNCwyNS43OTQsMC4xNjIsNTEuNTkyLTAuMDI0LDc3LjM4NmMtMC4wMjksNC4zMSwxLjM5NCw1LjM5MSw1LjUwNyw1LjM2YzIyLjQ1OC0wLjE3NCw0NC45MTYtMC4wODMsNjcuMzc0LTAuMDgxQzI1My4yNzcsMjA3LjAwNSwyNzYuMDM5LDIwNi45NTMsMjk4Ljc5OCwyMDcuMDYxeiIvPjxwYXRoIGZpbGw9IiNGMjhBMDAiIGQ9Ik00MTIuOTM4LDMyMy4yNTJjLTQuNjg4LTAuMTE3LTkuMzg0LTAuMDI2LTE0LjA3MS0wLjAzNWMtNC45OTQsMC05Ljk4OC0wLjA4Ny0xNC45OCwwLjAyNmMtNC41NDUsMC4xMDUtNy40NjQsMy4wNTMtNy41MjMsNy4zMTJjLTAuMDY3LDQuMjcyLDIuODIsNy41MDgsNy4yNzMsNy41NjljOS44MzMsMC4xNDEsMTkuNjcsMC4xMzYsMjkuNTA2LDAuMDAzYzQuNDM2LTAuMDU4LDcuMzU2LTMuMjk1LDcuMzE2LTcuNTQ2QzQyMC40MTgsMzI2LjM2Miw0MTcuNDU3LDMyMy4zNjcsNDEyLjkzOCwzMjMuMjUyeiIvPjxwYXRoIGZpbGw9IiNGMjhBMDAiIGQ9Ik00MTIuMDMyLDQxMC42NzZjLTQuMzktMC4wNTMtOC43NzYtMC4wMTEtMTMuMTYxLTAuMDFjLTQuNjkzLDAtOS4zODYtMC4wNC0xNC4wNzQsMC4wMWMtNS4yNTYsMC4wNTMtOC4zNjEsMi44MDUtOC40MzQsNy4zNjFjLTAuMDY5LDQuNTg0LDMuMDMxLDcuNTMyLDguMjAxLDcuNTdjOS4yMywwLjA2MiwxOC40NjEsMC4wNjQsMjcuNjg5LDAuMDA2YzUuMTc1LTAuMDMxLDguMjYyLTIuOTYxLDguMjA1LTcuNTdDNDIwLjQwOCw0MTMuNDg4LDQxNy4zMDIsNDEwLjczNCw0MTIuMDMyLDQxMC42NzZ6Ii8+PHBhdGggZmlsbD0iI0YyOEEwMCIgZD0iTTMwMC44ODEsNC4zN0MxMzcuODE0LDQuMzcsNS42MjIsMTM2LjU2Miw1LjYyMiwyOTkuNjNzMTMyLjE5MywyOTUuMjYsMjk1LjI1OSwyOTUuMjZjMTYzLjA2NywwLDI5NS4yNi0xMzIuMTkyLDI5NS4yNi0yOTUuMjZTNDYzLjk0OCw0LjM3LDMwMC44ODEsNC4zN3ogTTQ2My43OTMsNDU4LjE4NGMtMC4wMTIsNy41NzctMy4xOTcsMTAuNzY3LTEwLjc4NSwxMC43NzFjLTM2LjU1MywwLjAyLTczLjEwNCwwLjAyMi0xMDkuNjU5LTAuMDA1Yy02Ljk2LTAuMDAzLTEwLjMwOC0zLjM0Mi0xMC4zMTktMTAuMjk3Yy0wLjAzNy0xNy4yOTMtMC4wMjktMzQuNTgxLDAuMDAyLTUxLjg3NWMwLjAxLTYuOTk1LDMuMjk5LTEwLjI3NSwxMC4yOTctMTAuMjg4YzE4LjIwNi0wLjAyOSwzNi40MDQtMC4wMDksNTQuNjA0LTAuMDA5YzE4LjM1MiwwLDM2LjcwNS0wLjAxOSw1NS4wNTcsMC4wMDhjNy42MzcsMC4wMTIsMTAuNzk3LDMuMTU1LDEwLjgwNSwxMC43MzVDNDYzLjgxNyw0MjQuMjEsNDYzLjgyMSw0NDEuMTk3LDQ2My43OTMsNDU4LjE4NHogTTQ2My43OTMsMzcwLjc1M2MtMC4wMTIsNy41NTctMy4yMTEsMTAuNzQyLTEwLjgwMywxMC43NTNjLTE4LjM1MiwwLjAyMS0zNi43MDMsMC4wMDctNTUuMDU2LDAuMDA3Yy0xOC4wNDksMC0zNi4wOTcsMC4wMTUtNTQuMTQ0LTAuMDA3Yy03LjYxMi0wLjAxMS0xMC43NS0zLjE1Mi0xMC43NjItMTAuNzc3Yy0wLjAyNS0xNi45ODctMC4wMjUtMzMuOTcyLDAtNTAuOTZjMC4wMDgtNy42MDgsMy4xNDItMTAuNzI3LDEwLjc4Ny0xMC43MjljMzYuMzk4LTAuMDE2LDcyLjc5Ny0wLjAxNiwxMDkuMTk1LDBjNy41OTIsMC4wMDMsMTAuNzczLDMuMTg0LDEwLjc4MSwxMC43NTNDNDYzLjgxNywzMzYuNzgxLDQ2My44MjEsMzUzLjc2Niw0NjMuNzkzLDM3MC43NTN6IE01MDcuNTMzLDI5NC4zMzNjMCwxLjY4MywwLDMuNDI4LDAsNS4xNzRjLTAuMDAyLDU3LjIzNiwwLDExNC40NjktMC4wMDYsMTcxLjcwNGMtMC4wMDMsOS4xNzgtMy4xMzMsMTIuMzEyLTEyLjI3MSwxMi4zMjljLTE0LjkzOCwwLjAyNS0xNi40ODYtMS41MDQtMTYuNDg2LTE2LjI5N2MwLTU1LjU2NiwwLTExMS4xMywwLTE2Ni42OTRjMC0xLjk0NiwwLTMuODkxLDAtNi4xNjFjLTExNi43MzgsMC0yMzMuMDk4LDAtMzUwLjE5LDBjMCwxLjg0OCwwLDMuNzQ4LDAsNS42NDZjLTAuMDAxLDU3LjA4NCwwLDExNC4xNjctMC4wMDYsMTcxLjI0OWMwLDkuMTQ0LTMuMTM0LDEyLjI0NS0xMi4zMzMsMTIuMjU4Yy0xNC44ODcsMC4wMTctMTYuNDIzLTEuNTE4LTE2LjQyMi0xNi4zNmMwLjAwMi01NS43MTYsMC0xMTEuNDMyLDAtMTY3LjE0OWMwLTEuNzkzLDAtMy41ODYsMC01LjEyN2MtMC42MzctMC40LTAuODcyLTAuNjY5LTEuMTIyLTAuNjg2Yy0xMS41NDQtMC43MjEtMTMuNDUzLTIuNzY5LTEzLjQ1Mi0xNC40NjFjMC0xLjIxNS0wLjAxMy0yLjQyOSwwLjAwMi0zLjY0NWMwLjA5My03LjIwNiwzLjY5My0xMC43ODksMTEuMDI5LTEwLjc5NGMzMC45Ny0wLjAyMiw2MS45NC0wLjA5NCw5Mi45MTEsMC4wOTNjNC4wNzUsMC4wMjYsNi4yNTEtMS4xMDIsNy45NDUtNC44NjZjMy42NDctOC4xMDgsNy44MTctMTUuOTgsMTIuMDY0LTI0LjU0MWMtMi4yMzktMC4xLTMuODI3LTAuMjI5LTUuNDE2LTAuMjMxYy0xOC44MjQtMC4wMTMtMzcuNjUxLDAuMDA0LTU2LjQ3Ni0wLjAxNGMtMTEuODk4LTAuMDEyLTE4LjMyNC02LjM5LTE4LjMzLTE4LjIxN2MtMC4wMTUtMzYuMjgzLTAuMDE1LTcyLjU2OCwwLTEwOC44NTJjMC4wMDUtMTEuODc5LDYuMzkzLTE4LjI3MywxOC4yNi0xOC4yNzhjNTUuODY4LTAuMDEyLDExMS43MzctMC4wMTIsMTY3LjYwNS0wLjAwMWMxMS4xOTMsMC4wMDEsMTcuNzcsNi41NjgsMTcuNzc3LDE3LjgzNGMwLjAyNSwzNi43NCwwLjAyOSw3My40NzktMC4wMDIsMTEwLjIxOWMtMC4wMDgsMTAuNTU4LTYuNzkzLDE3LjI3MS0xNy40MTgsMTcuMjkxYy0xOC45NzcsMC4wMzQtMzcuOTU0LDAuMDA5LTU2LjkzMywwLjAwOWMtMS42NTgsMC0zLjMxOSwwLTUuNTQzLDBjMC41MjYsMS40NDIsMC44MTEsMi41MzEsMS4yOTgsMy41MjFjMy43NTMsNy42MDgsNy40MzQsMTUuMjU3LDExLjQxOCwyMi43NDRjMC43NiwxLjQyOCwyLjc1MywzLjEzMSw0LjE4MSwzLjEzNWM0NS4wODcsMC4xMjQsOTAuMTcxLDAuMDU0LDEzNS4yNTcsMC4wMDVjMC4xNDEsMCwwLjI3OS0wLjExMSwwLjYxNS0wLjI1NWMzLjI0OC0xNC4xNCwxNC43MTktMTcuOTM4LDI2LjkzMy0yMC40MTNjMi43NzEtMC41NjEsNC4xODctMS42MTEsNS4zNjQtMy45ODNjNy4wMDItMTQuMTAzLDE0LjE2Ni0yOC4xMjYsMjEuMTMxLTQyLjI0OWMwLjY2LTEuMzQ4LDEuMDY0LTMuODQzLDAuMzE2LTQuNzE5Yy04LjI3Ny05LjY3OC0xNi44MDMtMTkuMTQxLTI1LjQzOS0yOC44NjFjLTMuODYxLDIuOTg2LTYuMzk1LDUuODYxLTYuNjY0LDExLjE1MmMtMC4yMzEsNC40NTMtMi4zODEsOS00LjQ2NSwxMy4xMWMtMS45NTksMy44NjktNC42OCw0LjA3Ni03LjY5MSwxLjA5M2MtMTIuMDg0LTExLjk1OC0yNC4xMDktMjMuOTgyLTM2LjA2Ni0zNi4wNjZjLTMuMjMtMy4yNjMtMy4wNjgtNS45NTYsMS4wODUtNy45NjFjNC40MDktMi4xMjcsOS4yNDYtMy42NjUsMTQuMDYzLTQuNTE3YzIuOTkzLTAuNTI5LDUuMzYzLTEuMTcsNy40NjgtMy40MzNjMy43MjEtMy45OTksNy42NjEtNy43OTUsMTEuNTYtMTEuNjI3YzguMTA3LTcuOTcxLDE4LjUxNi05LjA4OCwyNy4yNy0yLjk3NGM4LjIxNiw1LjczNywxMC40OSwxNS42NTUsNi4yODIsMjUuOTYxYy0wLjU1MiwxLjM1Ni0wLjEyNSwzLjg1NCwwLjgzOSw0Ljk3MmM5LjIwMywxMC43MDEsMTguNTk4LDIxLjIzNywyNy45ODIsMzEuNzc5YzQuNTEzLDUuMDcyLDQuODc1LDcuMjc5LDEuNzYyLDEzLjQ3M2MtNi41OTYsMTMuMTMtMTMuMjI3LDI2LjI0Mi0xOS44MzIsMzkuMzY4Yy0wLjg3NiwxLjc0NC0xLjY4OSwzLjUyMS0yLjcyNSw1LjY4NGMxMS4xMTcsMy42MjYsMjEuNDg4LDcuMzY3LDI0LjA1NSwyMC42MDJjMTAuNDc2LDAsMjAuOTI2LTAuMDEzLDMxLjM3NSwwLjAwNGM4Ljg0NiwwLjAxNCwxMS45OTIsMy4yMDgsMTIuMDA2LDEyLjExOGMwLjAwMiwwLjYwNiwwLjAwMiwxLjIxMywwLjAwMiwxLjgyMUM1MjIuMTAyLDI5MS41Nyw1MjAuNDQzLDI5My4zNzEsNTA3LjUzMywyOTQuMzMzeiIvPjwvZz48L3N2Zz4=', 2);
    add_submenu_page(PLUGIN_SLUG, 'All Members', 'Members', 'manage_options', PLUGIN_SLUG);
    add_submenu_page(PLUGIN_SLUG, 'Add Member', 'Add Member', 'manage_options', 'csm-member-add', 'show_member_add');
    add_submenu_page(PLUGIN_SLUG, 'Profile', 'Profile', 'manage_options', 'csm-profile', 'show_profile');
    add_submenu_page(PLUGIN_SLUG, 'Membership Overview', 'Membership Overview', 'manage_options', 'csm-membership-overview', 'show_membership_overview');
    add_submenu_page(PLUGIN_SLUG, 'Add Membership Plan', 'Add Membership Plan', 'manage_options', 'csm-membership-add', 'show_membership_add');
    add_submenu_page(PLUGIN_SLUG, 'Calendar', 'Calendar', 'manage_options', 'csm-calendar', 'show_calendar');
    add_submenu_page(PLUGIN_SLUG, 'Invoices', 'Invoices', 'manage_options', 'csm-invoices', 'show_invoices');
    add_submenu_page(PLUGIN_SLUG, 'Payments', 'Payments', 'manage_options', 'csm-payments', 'show_payments');
    
    add_submenu_page(
        PLUGIN_SLUG,                //parent menu slug to attach to
        "",                          //page title (left blank)
                                     //menu title (inserted span with inline CSS)
       '<span style="display:block;  
        margin:1px 0 1px -5px; 
        padding:0; 
        height:1px; 
        line-height:1px; 
        background:#CCCCCC;"></span>',
        "create_users",              //capability (set to your requirement)
        "#"                          //slug (URL) shows Hash domain.com/# incase of mouse over
     );
    
    add_submenu_page(PLUGIN_SLUG, 'Settings', 'Settings', 'manage_options', 'csm-settings', 'show_settings');
    
    add_submenu_page(PLUGIN_SLUG, 'Plans', 'Plans', 'manage_options', 'csm-plans', 'show_plans');
    add_submenu_page(PLUGIN_SLUG, 'Add Plan', 'Add Plan', 'manage_options', 'csm-plan-add', 'show_plan_add');
    add_submenu_page(PLUGIN_SLUG, 'Edit Plan', 'Edit Plan', 'manage_options', 'csm-plan-edit', 'show_plan_edit');
    
    add_submenu_page(PLUGIN_SLUG, 'Workplaces', 'Workplaces', 'manage_options', 'csm-workplaces', 'show_workplaces');
    add_submenu_page(PLUGIN_SLUG, 'Add Workplace', 'Add Workplace', 'manage_options', 'csm-workplace-add', 'show_workplace_add');
    add_submenu_page(PLUGIN_SLUG, 'Edit Workplace', 'Edit Workplace', 'manage_options', 'csm-workplace-edit', 'show_workplace_edit');
    
    add_submenu_page(PLUGIN_SLUG, 'Email Templates', 'Email Templates', 'manage_options', 'csm-email-templates', 'show_email-templates');

}

//Add menu class to hide elements in menu /*sigh*/
add_action( 'admin_init','add_menu_class' );
function add_menu_class() 
{
    global $menu;
    foreach( $menu as $key => $value )
    {
        if( 'Coworking Space' == $value[0] ) {
            $menu[$key][4] .= " coworking-space-menu";
        }
    }
}

