<?php

class MembersTable extends WP_List_Table {

    public $csmMember;

    function __construct() {
        global $status, $page;

        $this->csmMember = new CsmMember;
        //Set parent defaults
        parent::__construct(array(
            'singular' => 'member', //singular name of the listed records
            'plural' => 'members', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'first_name':
            case 'profession':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    /*
     * Render checkbox column
     */

    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                /* $1%s */ $this->_args['singular'], //Let's simply repurpose the table's singular label ("movie")
                /* $2%s */ $item['identifier']                //The value of the checkbox should be the record's id
        );
    }

    /**
     * First name column
     * @param type $item
     * @return type
     */
    function column_last_name($item) {

        //Build row actions
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&identifier=%s">Edit</a>', $_REQUEST['page'], 'editmember', $item['identifier']),
            'delete' => sprintf('<a href="?page=%s&action=%s&identifier=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['identifier']),
        );

        //Return the title contents
        return sprintf('%1$s %2$s',
                /* $1%s */ $item['last_name'] . '<span style="color:silver">, ' . $item['first_name'] . '</span>',
                /* $2%s */ $this->row_actions($actions)
        );
    }

    /*
     * Render email column
     */

    function column_email($item) {
        return sprintf(
                '<a href="mailto:%1$s">%1$s</a>',
                /* $1%s */ $item['email']
        );
    }

    /*
     * Render created_at column
     */

    function column_created_at($item) {
        return $item['created_at'];
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'last_name' => 'Name',
            'email' => 'Email',
            'profession' => 'Profession',
            'created_at' => 'Member since',
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'last_name' => array('last_name', false),
            'email' => array('email', false),
            'profession' => array('profession', false),
            'created_at' => array('created_at', false)
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete',
        );
        return $actions;
    }

    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {
            //Single member delete action
            if (isset($_REQUEST['identifier'])) {
                try {
                    $member = $this->csmMember->delete($_REQUEST['identifier']);
                    csm_update($member['last_name'] . ', ' . $member['first_name'] . ' was deleted');
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
            //Delete multiple members
            else {
                try {
                    $res = "";
                    foreach ($_REQUEST['member'] as $identifier) {
                        $member = $this->csmMember->delete($identifier);
                        $res .= $member['last_name'] . ', ' . $member['first_name'] . ' was deleted<br>';
                    }
                    csm_update($res);
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
        }
    }

    function prepare_items() {
        global $wpdb;
        $per_page = 30;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $members = $this->csmMember->all(
                (($current_page - 1) * $per_page), $per_page, !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'ASC', !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'last_name'
        );
        $total_items = $this->csmMember->count();
        $this->items = $members;

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}
