<?php

/**
 * Flush all rewrite rules
 * @global type $wp_rewrite
 */
function cms_flush_rewrite_rules() 
{
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}

/**
 * Create all the database tables
 * @global type $wpdb
 * @global type $csm_db_version
 */
function create_csm_tables() {
    global $wpdb;
    global $csm_db_version;

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    //Create members
//    $table_members = $wpdb->prefix . 'csm_members';
//    $members_sql = "CREATE TABLE $table_members (
//		id INT(11) NOT NULL AUTO_INCREMENT,
//                identifier VARCHAR(100) NOT NULL,
//                first_name VARCHAR(100) NOT NULL,
//                last_name VARCHAR(100) NOT NULL,
//                email VARCHAR(100) NOT NULL,
//                company VARCHAR(100) NULL,
//                address VARCHAR(100) NULL,
//                locality VARCHAR(100) NULL,
//                country VARCHAR(100) NULL,
//                profession VARCHAR(100) NULL,
//                bio LONGTEXT NULL,
//                photo LONGTEXT NULL,
//                updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL,
//                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
//                PRIMARY KEY (`id`),
//		UNIQUE KEY identifier_key (identifier),
//                UNIQUE KEY email_key (email)    
//	);";
//    dbDelta($members_sql);

    //Workplaces
    $table_workplaces = $wpdb->prefix . 'csm_workplaces';
    $workplaces_sql = "CREATE TABLE $table_workplaces (
		id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                capacity INT(11) NOT NULL, 
                color VARCHAR(100) NOT NULL,
                features LONGTEXT NULL,
                updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL, 
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`)
	);";
    dbDelta($workplaces_sql);

    //Membership Plans
    $table_membership_plans = $wpdb->prefix . 'csm_plans';
    $membership_plans_sql = "CREATE TABLE $table_membership_plans (
		id INT(11) NOT NULL AUTO_INCREMENT,
                workplace_id INT(11) NOT NULL,
                name VARCHAR(100) NOT NULL,
                price INT(11) NOT NULL, 
                days INT(11) NOT NULL, 
                updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL, 
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`),
                CONSTRAINT `workplace_foreign` FOREIGN KEY (`workplace_id`) REFERENCES $table_workplaces (`id`)
	);";
    dbDelta($membership_plans_sql);

    //Email templates
    $table_templates = $wpdb->prefix . 'csm_templates';
    $templates_sql = "CREATE TABLE $table_templates (
		id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                slug VARCHAR(100) NOT NULL,
                template LONGTEXT NULL,
                updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL, 
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                KEY slug_key (slug),
                PRIMARY KEY (`id`)
	);";
    dbDelta($templates_sql);


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
                user_id bigint(20) unsigned NOT NULL,
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
                updated_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NULL, 
                created_at TIMESTAMP DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY identifier_key (identifier),
                KEY `sub_identifier_foreign` (`user_id`),
                CONSTRAINT `sub_identifier_foreign` FOREIGN KEY (`user_id`) REFERENCES " .$wpdb->prefix . "users (`ID`) ON DELETE CASCADE, 
                CONSTRAINT `plan_foreign` FOREIGN KEY (`plan_id`) REFERENCES $table_membership_plans (`id`)
                );";
    dbDelta($memberships_sql);

    add_option('csm_db_version', $csm_db_version);
}

/**
 * Add user role for member
 */
function add_user_roles() {
    add_role( 'csm_member', 'Coworking Space Member', array( 'read' => true, 'level_0' => true ) );
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
            'color' => '#4FC3F7',
        ));

        $CsmWorkplace->create(array(
            'name' => 'Dedicated Desk',
            'capacity' => 10,
            'color' => '#FF9800'
        ));

        $CsmWorkplace->create(array(
            'name' => 'Private Office',
            'capacity' => 2,
            'color' => '#4CAF50'
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
   $membercheck = get_users(array('role' => 'csm_member'));
    if (empty($membercheck)) {
        $CsmMember = new CsmMember();
        $CsmMember->create(array(
            'first_name' => 'Hank',
            'last_name' => 'Neville',
            'email' => 'hankneville@example.com',
            'profession' => 'Online marketeer',
            'bio' => 'I am an online marketeer',
            'company' => 'Neville Marketing',
            'address' => '2106 Bolman Court',
            'locality' => 'Baylis, Illinois',
            'country' => 'United States',
            'photo' => ''
        ));

        $CsmMember->create(array(
            'first_name' => 'Guido',
            'last_name' => 'Rus',
            'email' => 'Guidorus@example.com',
            'profession' => 'Software developer',
            'bio' => 'I am a software developer',
            'company' => 'Spottocamp',
            'address' => '',
            'locality' => 'Amsterdam',
            'country' => 'The Netherlands',
            'photo' => ''
        ));

        $CsmMember->create(array(
            'first_name' => 'Jim',
            'last_name' => 'Crush',
            'email' => 'jimcrush@example.com',
            'profession' => 'Entrepeneur',
            'bio' => 'I am an enterpeneur',
            'company' => 'Awesome Entrepeneurs With Loads Of Money',
            'address' => '305 Park Street',
            'locality' => 'San Jose, California',
            'country' => 'United States',
            'photo' => ''
        ));

        //Add a membership plan
        $user = get_users(array('role' => 'csm_member', 'number' => 1));
        $plan = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "csm_plans LIMIT 0,1", ARRAY_A);
        $CsmMembership = new CsmMembership();
        $CsmMembership->create(array(
            'user_id' => $user[0]->ID,
            'plan_id' => $plan['id'],
            'plan_start' => date('Y-m-d'),
            'plan_end' => date('Y-m-d', (time() + ($plan['days'] * 60 * 60 * 24))),
            'price' => $plan['price'],
            'vat' => 0,
            'price_total' => $plan['price']
        ));
    }

    //Add templates
    $templatescheck = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "csm_templates", ARRAY_A);
    if (empty($templatescheck)) {
        $wpdb->insert($wpdb->prefix . "csm_templates", array(
            "name" => "Invoice",
            "slug" => "invoice",
            "template" => file_get_contents(CSM_PLUGIN_PATH . '/app/views/emails/invoice.html'),
            'created_at' => current_time('mysql')
        ));
    }
}

//Set standard options for Coworking Space Manages
function default_options() {
    $isset = get_option('csm-settings-set');
    if (!$isset) {
        update_option('csm-settings-set', false);
        update_option('csm-name', get_option('blogname'));
        update_option('csm-address', '');
        update_option('csm-zipcode', '');
        update_option('csm-locality', '');
        update_option('csm-country', '');
        update_option('csm-email', '');
        update_option('csm-website', get_option('siteurl'));
        update_option('csm-currency', 'USD');
    }
}

?>
