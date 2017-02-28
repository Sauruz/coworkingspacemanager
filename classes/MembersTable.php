<?php

class MembersTable extends WP_List_Table {

    public $csmMember;

    function __construct() {
        global $status, $page;

        $this->csmMember = new CsmMember();
        //Set parent defaults
        parent::__construct(array(
            'singular' => 'member', //singular name of the listed records
            'plural' => 'members', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'email':
                return sprintf(
                        '<a href="mailto:%1$s">%1$s</a>',
                        /* $1%s */ $item['email']
                );
            case 'payments_open':
                if ($item['payments_open']) {
                    return '<i class="fa fa-fw fa-lg fa-exclamation-triangle text-warning" aria-hidden="true"></i> ' . $item['payments_open'] . ($item['payments_open'] > 1 ? ' payments to receive' : ' payment to receive');
                } else {
                    return '<i class="fa fa-fw fa-lg fa-check-circle text-success" aria-hidden="true"></i> 0 payments to receive';
                }
            case 'invoices_open':
                if ($item['invoices_open']) {
                    return '<i class="fa fa-fw fa-lg fa-exclamation-triangle text-warning" aria-hidden="true"></i> ' . $item['invoices_open'] . ($item['invoices_open'] > 1 ? ' invoices to send' : ' invoice to send');
                } else {
                    return '<i class="fa fa-lg fa-fw fa-check-circle text-success" aria-hidden="true"></i> 0 invoices to send';
                }
            case 'plan':
                if ($item['plan']) {
                    return '<strong><i class="fa fa-fw fa-clock-o text-success" aria-hidden="true"></i> ' . $item['plan'] . '<br><i class="fa fa-fw fa-desktop text-success" aria-hidden="true"></i> ' . $item['workplace'] . '</strong>';
                } else {
                    return '';
                }
            default:
                return $item[$column_name];
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
            'edit' => sprintf('<a href="?page=%s&member_identifier=%s">Edit</a>', 'csm-edit-member', $item['identifier']),
            'delete' => sprintf('<a href="?page=%s&action=%s&identifier=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['identifier']),
        );

        //Return the title contents
        return sprintf('%1$s %2$s',
                /* $1%s */ sprintf('<a class="row-title" href="?page=%s&member_identifier=%s" aria-label="">' . $item['last_name'] . '</a><span style="color:silver">, ' . $item['first_name'] . '</span>', 'csm-membership-overview', $item['identifier']),
                /* $2%s */ $this->row_actions($actions)
        );
    }

    function column_membership_status($item) {
        if ((strtotime($item['plan_start']) <= time()) && (strtotime($item['plan_end']) > time())) {
            return '<span class="label label-success label-member-active">Active</span>';
        } else if ((strtotime($item['plan_start']) > time()) && (strtotime($item['plan_end']) > time())) {
            return '<span class="label label-info label-member-active">Pending</span>';
        } else {
            return '<span class="label label-default label-member-active" style="display:block">Inactive</span>';
        }
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'last_name' => 'Name',
//            'email' => 'Email',
            'membership_status' => 'Membership Status',
            'plan' => 'Membership Plan',
            'plan_end' => 'Membership Expires',
            'payments_open' => 'Payments',
            'invoices_open' => 'Invoices'
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'last_name' => array('last_name', false),
//            'email' => array('email', false),
            'membership_status' => array('plan', false),
            'plan' => array('plan', false),
            'plan_end' => array('plan_end', false),
            'payments_open' => array('payments_open', false),
            'invoices_open' => array('invoices_open', false),
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
                    csm_update($member['first_name'] . ' ' . $member['last_name'] . ' was deleted');
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
                        $res .= $member['first_name'] . ' ' . $member['last_name'] . ' was deleted<br>';
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
                (($current_page - 1) * $per_page), $per_page, !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'DESC', !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'plan'
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
