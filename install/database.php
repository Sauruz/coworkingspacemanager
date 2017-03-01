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

    //Workplaces
    $table_workplaces = $wpdb->prefix . 'csm_workplaces';
    $workplaces_sql = "CREATE TABLE $table_workplaces (
		id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                capacity INT(11) NOT NULL, 
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`)
	) $charset_collate;";
    dbDelta($workplaces_sql);

    //Membership Plans
    $table_membership_plans = $wpdb->prefix . 'csm_plans';
    $membership_plans_sql = "CREATE TABLE $table_membership_plans (
		id INT(11) NOT NULL AUTO_INCREMENT,
                workplace_id INT(11) NOT NULL,
                name VARCHAR(100) NOT NULL,
                price INT(11) NOT NULL, 
                days INT(11) NOT NULL, 
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `workplace_foreign` FOREIGN KEY (`workplace_id`) REFERENCES $table_workplaces (`id`)
	) $charset_collate;";
    dbDelta($membership_plans_sql);


    //Spaces
    /**
     * Board room
     * Meeting room
     * Skype room etc.
     */
    //Memberships
    $table_membership = $wpdb->prefix . 'csm_memberships';
    $memberships_sql = "CREATE TABLE $table_membership (
		id INT(11) NOT NULL AUTO_INCREMENT,
                identifier VARCHAR(100) NOT NULL,
                member_identifier VARCHAR(100) NOT NULL,
                plan_id INT(11) NOT NULL,
                plan_start DATE DEFAULT '0000-00-00' NOT NULL,
                plan_end DATE DEFAULT '0000-00-00' NOT NULL,
                payment BOOLEAN DEFAULT 0 NOT NULL,
                payment_method VARCHAR(20) NULL,
                payment_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL,
                price INT(11) NULL,
                vat INT(11) NULL,
                price_total INT(11) NULL,
                invoice_sent BOOLEAN DEFAULT 0 NOT NULL,
                invoice_sent_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL,
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY identifier_key (identifier),
                KEY `sub_identifier_foreign` (`member_identifier`),
                CONSTRAINT `sub_identifier_foreign` FOREIGN KEY (`member_identifier`) REFERENCES $table_members (`identifier`) ON DELETE CASCADE, 
                CONSTRAINT `plan_foreign` FOREIGN KEY (`plan_id`) REFERENCES $table_membership_plans (`id`)
                ) $charset_collate;";
    dbDelta($memberships_sql);

    add_option('csm_db_version', $csm_db_version);
}

/**
 * Add dummy users to database
 */
function dummy_data() {
    global $wpdb;

    //Add workplace
    $workplacecheck = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "csm_workplace", ARRAY_A);
    $planscheck = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "csm_plans", ARRAY_A);
    if (empty($workplacecheck) && empty($planscheck)) {
        $CsmWorkplace = new CsmWorkplace();

        $CsmWorkplace->create(array(
            'name' => 'Hot Desk',
            'capacity' => 45,
        ));

        $CsmWorkplace->create(array(
            'name' => 'Dedicated Desk',
            'capacity' => 10,
        ));

        $CsmWorkplace->create(array(
            'name' => 'Private Office',
            'capacity' => 2,
        ));


        $workplaceid = $wpdb->get_var("SELECT id FROM " . $wpdb->prefix . "csm_workplace LIMIT 0,1");

        //Add plans
        $CsmPlan = new CsmPlan();
        $CsmPlan->create(array(
            'workplace_id' => 1,
            'name' => 'Day',
            'price' => 10,
            'days' => 1,
        ));

        $CsmPlan->create(array(
            'workplace_id' => 1,
            'name' => 'Week',
            'price' => 60,
            'days' => 7,
        ));

        $CsmPlan->create(array(
            'workplace_id' => 1,
            'name' => 'Month',
            'price' => 200,
            'days' => 30,
        ));
    }

    //Add member
    $membercheck = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "csm_members", ARRAY_A);
    if (empty($membercheck)) {
        $CsmMember = new CsmMember();
        $CsmMember->create(array(
            'first_name' => 'Hank',
            'last_name' => 'Neville',
            'email' => 'hankneville@example.com',
            'profession' => 'Online marketeer',
            'bio' => 'I am an online marketeer',
            'photo' => ''
        ));

        $CsmMember->create(array(
            'first_name' => 'Guido',
            'last_name' => 'Rus',
            'email' => 'Guidorus@example.com',
            'profession' => 'Software developer',
            'bio' => 'I am a software developer',
            'photo' => ''
        ));

        $CsmMember->create(array(
            'first_name' => 'Jim',
            'last_name' => 'Crush',
            'email' => 'jimcrush@example.com',
            'profession' => 'Entrepeneur',
            'bio' => 'I am a enterpeneur',
            'photo' => ''
        ));

        //Add a membership plan
        $memberidentifier = $wpdb->get_var("SELECT identifier FROM " . $wpdb->prefix . "csm_members LIMIT 0,1");
        $plan = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "csm_plans LIMIT 0,1", ARRAY_A);
        $CsmMembership = new CsmMembership();
        $CsmMembership->create(array(
            'member_identifier' => $memberidentifier,
            'plan_id' => $plan['id'],
            'plan_start' => date('Y-m-d'),
            'plan_end' => date('Y-m-d', (time() + ($plan['days'] * 60 * 60 * 24))),
            'price' => $plan['price'],
            'vat' => 0,
            'price_total' => $plan['price']
        ));
    }
}

    //Set standard options for Coworking Space Manages
function default_options() {
    update_option('csm-currency', 'USD');
}

?>
