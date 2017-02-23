<?php
global $csm_db_version;
$csm_db_version = '1.0';

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

//Install
include( plugin_dir_path( __FILE__ ) . 'install/database.php');

//Pages
include( plugin_dir_path( __FILE__ ) . 'backend/main.php');


register_activation_hook( __FILE__, 'create_csm_tables' );
//register_activation_hook( __FILE__, 'jal_install_data' );