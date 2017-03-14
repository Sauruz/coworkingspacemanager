<?php

global $csm_db_version;
$csm_db_version = '1.0';
define('PLUGIN_SLUG', 'coworking-space-manager');
define('CMS_LOCALE', str_replace('_', '-', strtolower(get_locale())));
define('CMS_SIMPLE_LOCALE', (explode('-', CMS_LOCALE)[0]));
define('CSM_PLUGIN_PATH', plugin_dir_path(__FILE__));

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
if (!class_exists('WP_List_Table_Custom')) {
    require_once(CSM_PLUGIN_PATH . 'app/assets/class-wp-list-table-custom.php' );
}

//Styles & javascript
function csm_style() {
    wp_register_style('csm_style', plugins_url('dist/css/styles.css', __FILE__));
    wp_enqueue_style('csm_style');
    wp_register_script('csm_js', plugins_url('dist/js/app.js', __FILE__));
    wp_enqueue_script('csm_js');
    wp_register_script('i18n', plugins_url('dist/js/i18n/angular-locale_' . CMS_LOCALE . '.js', __FILE__));
    wp_enqueue_script('i18n');
    if (CMS_SIMPLE_LOCALE !== 'en') {
        wp_register_script('calendar-locale', plugins_url('dist/js/calendar-locale/' . CMS_SIMPLE_LOCALE . '.js', __FILE__));
        wp_enqueue_script('calendar-locale');
    }
}

add_action('admin_init', 'csm_style');


//Autoload composer file
require CSM_PLUGIN_PATH . 'vendor/autoload.php';

//Assets
include(CSM_PLUGIN_PATH . '/app/assets/currency-symbols.php');

//Standard CSM Settings Settings
define('CSM_SETTINGS_SET', get_option('csm-settings-set'));
define('CSM_NAME', stripslashes(get_option('csm-name')));
define('CSM_ADDRESS', stripslashes(get_option('csm-address')));
define('CSM_ZIPCODE', stripslashes(get_option('csm-zipcode')));
define('CSM_LOCALITY', stripslashes(get_option('csm-locality')));
define('CSM_COUNTRY', stripslashes(get_option('csm-country')));
define('CSM_EMAIL', get_option('csm-email'));
define('CSM_WEBSITE', get_option('csm-website'));
define('CSM_CURRENCY', get_option('csm-currency'));
define('CSM_CURRENCY_SYMBOL', html_entity_decode($currency_symbols[CSM_CURRENCY]));


//Functions
include(CSM_PLUGIN_PATH . 'app/assets/functions.php');

//Models
include(CSM_PLUGIN_PATH . 'app/models/member.model.php');
include(CSM_PLUGIN_PATH . 'app/models/membership.model.php');
include(CSM_PLUGIN_PATH . 'app/models/plan.model.php');
include(CSM_PLUGIN_PATH . 'app/models/workplace.model.php');
include(CSM_PLUGIN_PATH . 'app/models/templates.model.php');
include(CSM_PLUGIN_PATH . 'app/models/settings.model.php');
include(CSM_PLUGIN_PATH . 'app/models/invoice.model.php');

//Install
include(CSM_PLUGIN_PATH . 'install/database.php');

//Classes
include(CSM_PLUGIN_PATH . 'app/tables/members-table.php');
include(CSM_PLUGIN_PATH . 'app/tables/member-membership-table.php');
include(CSM_PLUGIN_PATH . 'app/tables/memberships-table.php');
include(CSM_PLUGIN_PATH . 'app/tables/plans-table.php');
include(CSM_PLUGIN_PATH . 'app/tables/workplaces-table.php');

//Pages
include(CSM_PLUGIN_PATH . 'app/pages/members.php');
include(CSM_PLUGIN_PATH . 'app/pages/member-add.php');
include(CSM_PLUGIN_PATH . 'app/pages/member-memberships.php');
include(CSM_PLUGIN_PATH . 'app/pages/member-membership-add.php');
include(CSM_PLUGIN_PATH . 'app/pages/member-profile.php');
include(CSM_PLUGIN_PATH . 'app/pages/memberships.php');
include(CSM_PLUGIN_PATH . 'app/pages/membership-add.php');
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

    add_menu_page('Coworking Space Manager', 'Coworking Space', 'manage_options', PLUGIN_SLUG, 'show_members', 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSI2MDBweCIgaGVpZ2h0PSI2MDBweCIgdmlld0JveD0iMCAwIDYwMCA2MDAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDYwMCA2MDAiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxwYXRoIGZpbGw9IiNGRjQ3NDIiIGQ9Ik0yMDAuMDYxLDIyNC43NWMtMjguOTM4LTE3LjI2Ni01Ny44MTctMzQuNjMzLTg2LjcxMy01MS45N2MtMC45MDQtMC41NDEtMS44NDYtMS4wMi0zLjI5Ni0xLjgxOWMwLDEuNDk5LDAsMi40MTYsMCwzLjMzMmMwLDc0LjM3MywwLjAxOCwxNDguNzQ1LTAuMDY4LDIyMy4xMThjLTAuMDAzLDIuNjQyLDEuMDQzLDMuODcxLDMuMTIyLDUuMTA5YzE5LjIyOCwxMS40MzksMzguNCwyMi45NzEsNTcuNTg2LDM0LjQ3OWMxMC41MTcsNi4zMDksMjEuMDMsMTIuNjE4LDMyLjMwNCwxOS4zODJjMC0xLjY2NSwwLTIuNDg1LDAtMy4zMDVjMC4wMDEtNzQuMzcyLTAuMDEzLTE0OC43NDQsMC4wNTctMjIzLjExOEMyMDMuMDUzLDIyNy40MTYsMjAyLjIyOCwyMjYuMDQzLDIwMC4wNjEsMjI0Ljc1eiIvPjxwYXRoIGZpbGw9IiNGMjNCM0IiIGQ9Ik0yOTkuMjUsMUMxMzQuNTMxLDEsMSwxMzQuNTMxLDEsMjk5LjI1QzEsNDYzLjk2OSwxMzQuNTMxLDU5Ny41LDI5OS4yNSw1OTcuNWMxNjQuNzE5LDAsMjk4LjI1LTEzMy41MzEsMjk4LjI1LTI5OC4yNUM1OTcuNSwxMzQuNTMxLDQ2My45NjksMSwyOTkuMjUsMXogTTUwOC4zODEsNDk1LjVjLTI0LjQyLTE0LjU5My00OC44NDgtMjkuMTc3LTczLjI1OS00My43ODRjLTE4LjcyOS0xMS4yMDctMzcuNDczLTIyLjM5LTU2LjExNi0zMy43MzdjLTIuNTY1LTEuNTYyLTQuNDY5LTEuNjA4LTcuMTI2LTAuMjcyYy01MC40NiwyNS4zNDYtMTAwLjk4Myw1MC41NjItMTUxLjQzNiw3NS45MjJjLTMuMDUzLDEuNTM1LTUuMjA4LDEuNTM3LTguMjIyLTAuMjg0Yy00MS43NDItMjUuMjA2LTgzLjU3NS01MC4yNTgtMTI1LjQxOC03NS4yOTRjLTIuMTctMS4zLTMuMzg5LTIuNTUxLTMuMzg2LTUuNDEyYzAuMDk0LTk1LjE0OCwwLjA3OC0xOTAuMjk3LDAuMDc4LTI4NS40NDVjMC0wLjkzOCwwLTEuODc0LDAtMy4zOTNjMS43NDUsMC45NTUsMy4wNTQsMS42MTIsNC4zMDgsMi4zNjVjNDEuNjk4LDI1LjAwOSw4My40MDgsNDkuOTk5LDEyNS4wNDUsNzUuMTA5YzIuNTg3LDEuNTYsNC40OTUsMS41NzYsNy4xMzgsMC4yNDljNTAuNDYxLTI1LjM0MiwxMDAuOTg0LTUwLjU1OSwxNTEuNDM1LTc1LjkyM2MzLjA2Ny0xLjU0Miw1LjIyNS0xLjUwNCw4LjIxOSwwLjMwMmM0MS42MjYsMjUuMTI5LDgzLjM0NCw1MC4xMDMsMTI1LjA1Nyw3NS4wOWMxLjEzNSwwLjY4LDIuNDUyLDEuMDU0LDMuNjg0LDEuNTcxQzUwOC4zODEsMzAwLjIwNyw1MDguMzgxLDM5Ny44NTQsNTA4LjM4MSw0OTUuNXoiLz48cGF0aCBmaWxsPSIjRkY0NzQyIiBkPSJNMzYyLjMyNywxNjAuNDI5Yy0xLjgxNywwLjgzMi0zLjA2MywxLjM1Ny00LjI3LDEuOTZjLTQxLjQ5MywyMC43MzktODIuOTYzLDQxLjUyLTEyNC41MDYsNjIuMTU1Yy0zLjAwOCwxLjQ5NC00LjA4NywzLjEyNS00LjA4Myw2LjUyMWMwLjEwOCw3NC4zNywwLjA4MiwxNDguNzQxLDAuMDgyLDIyMy4xMTJjMCwxLjM1NSwwLDIuNzEyLDAsNC41ODNjMS42NTEtMC43MzMsMi44OTQtMS4yMjksNC4wODYtMS44MjRjNDEuNjE2LTIwLjgwMiw4My4yMDktNDEuNjQ3LDEyNC44NzUtNjIuMzQ4YzIuODkyLTEuNDM4LDMuOTAyLTIuOTYyLDMuODk3LTYuMjIyYy0wLjEwNi03NC41MDgtMC4wODItMTQ5LjAxNy0wLjA4Mi0yMjMuNTI1QzM2Mi4zMjcsMTYzLjYwNCwzNjIuMzI3LDE2Mi4zNjcsMzYyLjMyNywxNjAuNDI5eiIvPjxwYXRoIGZpbGw9IiNGRjQ3NDIiIGQ9Ik00NzguODk2LDIxNi43OTNjLTI4LjkyMS0xNy4yOTctNTcuODE0LTM0LjYzOC04Ni43MjEtNTEuOTU5Yy0wLjkwMy0wLjU0LTEuODY4LTAuOTc0LTMuMTItMS42MjJjLTAuMDcsMS40ODItMC4xNjYsMi41NS0wLjE2NiwzLjYxN2MtMC4wMDgsNzQuMDk3LDAuMDEyLDE0OC4xOTMtMC4wNzIsMjIyLjI5Yy0wLjAwNCwyLjc1LDAuOTMsNC4xMzIsMy4yMjgsNS40OTVjMTkuNDgxLDExLjU1NiwzOC44NzUsMjMuMjU0LDU4LjI5NywzNC45MDhjMTAuMjcxLDYuMTYzLDIwLjU0MiwxMi4zMjMsMzEuMzQxLDE4LjgwM2MwLjA3OC0xLjMxNSwwLjEzOC0xLjg2MywwLjEzOC0yLjQxNGMwLjAwNS03NC43ODgtMC4wMTMtMTQ5LjU3NSwwLjA4MS0yMjQuMzYyQzQ4MS45MDQsMjE4Ljk5MSw0ODAuNzc1LDIxNy45MTgsNDc4Ljg5NiwyMTYuNzkzeiIvPjwvZz48L3N2Zz4=);', 2);
    add_submenu_page(PLUGIN_SLUG, 'All Members', 'Members', 'manage_options', PLUGIN_SLUG);
    add_submenu_page(PLUGIN_SLUG, 'Add Member', 'Add Member', 'manage_options', 'csm-member-add', 'show_member_add');
    add_submenu_page(PLUGIN_SLUG, 'Profile', 'Profile', 'manage_options', 'csm-member-profile', 'show_member_profile');
    add_submenu_page(PLUGIN_SLUG, 'Membership Overview', 'Membership Overview', 'manage_options', 'csm-member-memberships', 'show_member_memberships');
    add_submenu_page(PLUGIN_SLUG, 'New Membership', 'New Membership', 'manage_options', 'csm-member-membership-add', 'show_member_membership_add');
    add_submenu_page(PLUGIN_SLUG, 'Memberships', 'Memberships', 'manage_options', 'csm-memberships', 'show_memberships');
    add_submenu_page(PLUGIN_SLUG, 'New Membership', 'New Membership', 'manage_options', 'csm-membership-add', 'show_membership_add');
    add_submenu_page(PLUGIN_SLUG, 'Calendar', 'Calendar', 'manage_options', 'csm-calendar', 'show_calendar');

    add_submenu_page(
            PLUGIN_SLUG, //parent menu slug to attach to
            "", //page title (left blank)
            //menu title (inserted span with inline CSS)
            '<span style="display:block;  
        margin:1px 0 1px -5px; 
        padding:0; 
        height:1px; 
        line-height:1px; 
        background:#CCCCCC;"></span>', "create_users", //capability (set to your requirement)
            "#"                          //slug (URL) shows Hash domain.com/# incase of mouse over
    );

    add_submenu_page(PLUGIN_SLUG, 'Settings', 'Settings', 'manage_options', 'csm-settings', 'show_settings');

    add_submenu_page(PLUGIN_SLUG, 'Plans', 'Plans', 'manage_options', 'csm-plans', 'show_plans');
    add_submenu_page(PLUGIN_SLUG, 'Add Plan', 'Add Plan', 'manage_options', 'csm-plan-add', 'show_plan_add');
    add_submenu_page(PLUGIN_SLUG, 'Edit Plan', 'Edit Plan', 'manage_options', 'csm-plan-edit', 'show_plan_edit');

    add_submenu_page(PLUGIN_SLUG, 'Workplaces', 'Workplaces', 'manage_options', 'csm-workplaces', 'show_workplaces');
    add_submenu_page(PLUGIN_SLUG, 'Add Workplace', 'Add Workplace', 'manage_options', 'csm-workplace-add', 'show_workplace_add');
    add_submenu_page(PLUGIN_SLUG, 'Edit Workplace', 'Edit Workplace', 'manage_options', 'csm-workplace-edit', 'show_workplace_edit');
}

//Add menu class to hide elements in menu /*sigh*/
add_action('admin_init', 'add_menu_class');

function add_menu_class() {
    global $menu;
    foreach ($menu as $key => $value) {
        if ('Coworking Space' == $value[0]) {
            $menu[$key][4] .= " coworking-space-menu";
        }
    }
}
