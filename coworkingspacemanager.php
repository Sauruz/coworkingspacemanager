<?php

/*
  Plugin Name: Coworking Space Manager
  Plugin URI:  http://www.de-rus.nl
  Description: A Wordpress plugin for coworking spaces. Manage members, bookings and invoices.
  Version:     1.0
  Author:      Guido Rus
  Text Domain: coworkingspacemanager
  Author URI:  http://www.de-rus.nl
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */



global $csm_db_version;
$csm_db_version = '1.0';
define('PLUGIN_SLUG', 'coworking-space-manager');
define('CMS_LOCALE', str_replace('_', '-', strtolower(get_locale())));
define('CMS_SIMPLE_LOCALE', (explode('-', CMS_LOCALE)[0]));
define('CSM_PLUGIN_PATH', plugin_dir_path(__FILE__));

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

include(CSM_PLUGIN_PATH . 'routing.php');

//Ajax
include(CSM_PLUGIN_PATH . 'app/assets/ajax.php');

add_action('init', 'register_session');

register_activation_hook(__FILE__, 'cms_flush_rewrite_rules');
register_activation_hook(__FILE__, 'create_csm_tables');
register_activation_hook(__FILE__, 'add_user_roles');
register_activation_hook(__FILE__, 'dummy_data');
register_activation_hook(__FILE__, 'default_options');

//Add menu to admin
add_action('admin_menu', 'csm_menu');

function csm_menu() {

    add_menu_page('Coworking Space Manager', 'Coworking Space', 'manage_options', PLUGIN_SLUG, 'show_members', plugins_url('coworkingspacemanager/src/img/logo-orange-small.svg' ), 2);
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

