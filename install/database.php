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

    //Create members
    $table_members = $wpdb->prefix . 'csm_members';
    $members_sql = "CREATE TABLE $table_members (
		id INT(11) NOT NULL AUTO_INCREMENT,
                identifier VARCHAR(100) NOT NULL,
                first_name VARCHAR(100) NOT NULL,
                last_name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                profession VARCHAR(100) NOT NULL,
                bio LONGTEXT NULL,
                photo LONGTEXT NULL,
                updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL,
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`),
		UNIQUE KEY identifier_key (identifier),
                UNIQUE KEY email_key (email)
                
	) $charset_collate;";
    dbDelta($members_sql);
    
    //subscription types
    $table_subscription_types = $wpdb->prefix . 'csm_plans';
    $subscription_types_sql = "CREATE TABLE $table_subscription_types (
		id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                price INT(11) NOT NULL,
                PRIMARY KEY (`id`)
	) $charset_collate;";
    dbDelta($subscription_types_sql);
    

    //Memberships
    $table_membership = $wpdb->prefix . 'csm_memberships';
    $memberships_sql = "CREATE TABLE $table_membership (
		id INT(11) NOT NULL AUTO_INCREMENT,
                identifier VARCHAR(100) NOT NULL,
                member_identifier VARCHAR(100) NOT NULL,
                plan VARCHAR(10) NULL,
                plan_start DATE DEFAULT '0000-00-00' NOT NULL,
                plan_end DATE DEFAULT '0000-00-00' NOT NULL,
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
                KEY `sub_identifier_foreign` (`member_identifier`),
                CONSTRAINT `sub_identifier_foreign` FOREIGN KEY (`member_identifier`) REFERENCES $table_members (`identifier`) ON DELETE CASCADE
	) $charset_collate;";
    dbDelta($memberships_sql);



    add_option('csm_db_version', $csm_db_version);
}

/**
 * Add dummy users to database
 */
function dummy_user() {
    $user = new CsmMember();
        $user->create(array(
            'first_name' => 'Hank',
            'last_name' => 'Neville',
            'email' => 'hankneville@example.com',
            'profession' => 'Online marketeer',
            'bio' => 'I am an online marketeer',
            'photo' => ''
        ));

        $user->create(array(
            'first_name' => 'Guido',
            'last_name' => 'Rus',
            'email' => 'Guidorus@example.com',
            'profession' => 'Software developer',
            'bio' => 'I am a software developer',
            'photo' => ''
        ));

        $user->create(array(
            'first_name' => 'Jim',
            'last_name' => 'Crush',
            'email' => 'jimcrush@example.com',
            'profession' => 'Entrepeneur',
            'bio' => 'I am a enterpeneur',
            'photo' => ''
        ));
}

?>
