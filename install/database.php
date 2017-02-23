<?php

/**
 * Create all the database tables
 * @global type $wpdb
 * @global type $csm_db_version
 */
function create_csm_tables() {
    global $wpdb;
    global $csm_db_version;

    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    //Create users
    $table_users = $wpdb->prefix . 'csm_users';
    $users_sql = "CREATE TABLE $table_users (
		id INT(11) NOT NULL AUTO_INCREMENT,
                identifier VARCHAR(100) NOT NULL,
                first_name VARCHAR(100) NOT NULL,
                last_name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                description LONGTEXT NULL,
                photo LONGTEXT NULL,
                updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL,
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`),
		UNIQUE KEY identifier_key (identifier),
                UNIQUE KEY email_key (email)
                
	) $charset_collate;";
    dbDelta($users_sql);
    
    //subscription types
    $table_subscription_types = $wpdb->prefix . 'csm_subscription_types';
    $subscription_types_sql = "CREATE TABLE $table_subscription_types (
		id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                price INT(11) NOT NULL,
                PRIMARY KEY (`id`)
	) $charset_collate;";
    dbDelta($subscription_types_sql);
    

    //subscription 
    $table_subscriptions = $wpdb->prefix . 'csm_subscriptions';
    $subscriptions_sql = "CREATE TABLE $table_subscriptions (
		id INT(11) NOT NULL AUTO_INCREMENT,
                identifier VARCHAR(100) NOT NULL,
                user_identifier VARCHAR(100) NOT NULL,
                subscription_type VARCHAR(10) NULL,
                subscription_start TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                subscription_end TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                status VARCHAR(20) DEFAULT 'pending' NOT NULL,
                payment BOOLEAN DEFAULT 0 NOT NULL,
                payment_method VARCHAR(20) NULL,
                payment_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL,
                price INT(11) NULL,
                vat INT(11) NULL,
                price_total INT(11) NULL,
                invoice_sent BOOLEAN DEFAULT 0 NOT NULL,
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY identifier_key (identifier),
                KEY `sub_identifier_foreign` (`user_identifier`),
                CONSTRAINT `sub_identifier_foreign` FOREIGN KEY (`user_identifier`) REFERENCES `wp_csm_users` (`identifier`) ON DELETE CASCADE
	) $charset_collate;";
    dbDelta($subscriptions_sql);



    add_option('csm_db_version', $csm_db_version);
}

function jal_install_data() {
    global $wpdb;

    $welcome_name = 'Mr. WordPress';
    $welcome_text = 'Congratulations, you just completed the installation!';

    $table_name = $wpdb->prefix . 'csm_users';

    $wpdb->insert(
            $table_name, array(
        'time' => current_time('mysql'),
        'name' => $welcome_name,
        'text' => $welcome_text,
            )
    );
}

?>
