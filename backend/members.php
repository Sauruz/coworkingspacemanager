<?php

function show_members() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    //Create an instance of our package class...
    $usersTable = new UsersTable();
    //Fetch, prepare, sort, and filter our data...
    $usersTable->prepare_items();

    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Members</h1>';
    echo ' <a href="?page=add-member" class="page-title-action">Add Member</a>';
    $usersTable->display();
    echo '</div>';

//    $user = new CsmUser();
//    try {
//        $user->create(array(
//            'first_name' => 'Bram dfgdfg dfg dfg dfggfdgd dfg ddfgg ',
//            'last_name' => 'van der Velde',
//            'email' => 'Bramdfgdfg@hotmail.com',
//            'description' => 'Ik ben een software developer',
//            'photo' => 'hoi'
//        ));
//    } catch (Exception $e) {
//        //Give error 
//        echo $e->getMessage();
//    }
}
