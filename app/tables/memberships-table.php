<?php

class MembershipTable extends WP_List_Table_Custom {

    private $csmMembership;

    /**
     * Construct
     * @global type $status
     * @global type $page
     */
    public function __construct() {
        global $status, $page;

        $this->csmMembership = new CsmMembership();
        //Set parent defaults
        parent::__construct(array(
            'singular' => 'membership', //singular name of the listed records
            'plural' => 'memberships', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
    }

    /**
     * Set column names
     * @param type $item
     * @param type $column_name
     * @return string
     */
    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'member_identifier':
                return '<strong><i class="fa fa-fw fa-clock-o text-success" aria-hidden="true"></i> ' . $item['plan_name'] . '<br><i class="fa fa-fw fa-desktop text-success" aria-hidden="true"></i> ' . $item['workplace_name'] . '</strong>';
            case 'plan_start':
                return '<span ng-bind="' . (strtotime($item['plan_start']) * 1000) . ' | date : \'mediumDate\'">' . $item['plan_start'] . '</span>';
            case 'plan_end':
                return '<span ng-bind="' . (strtotime($item['plan_end']) * 1000) . ' | date : \'mediumDate\'">' . $item['plan_end'] . '</span>';
            case 'price_total':
                return '<span ng-bind="' . $item['price_total'] . ' | currency : \'' . CSM_CURRENCY_SYMBOL . '\'">' . CSM_CURRENCY_SYMBOL . $item['price_total'] . '</span>';
            case 'payment':
                if ($item['payment']) {
                    return '<payment paid="true" payment-at="' . date('Y-m-d', strtotime($item['payment_at'])) . '" payment-method="' . $item['payment_method'] . '" identifier="' . $item['identifier'] . '" price="' . $item['price'] . '" start="' . $item['plan_start'] . '" end="' . $item['plan_end'] . '"></payment>';
                } else {
                    return '<payment paid="false" identifier="' . $item['identifier'] . '" price="' . $item['price'] . '" start="' . $item['plan_start'] . '" end="' . $item['plan_end'] . '"></payment>';
                }
            case 'invoice_sent':
                if ($item['invoice_sent']) {
                    return '<invoice invoice-sent="true" invoice-sent-at="' . date('Y-m-d', strtotime($item['invoice_sent_at'])) . '" payment-method="' . $item['payment_method'] . '" identifier="' . $item['identifier'] . '" price="' . $item['price'] . '" start="' . $item['plan_start'] . '" end="' . $item['plan_end'] . '"></invoice>';
                } else {
                    return '<invoice invoice-sent="false" '
                            . 'identifier="' . $item['identifier'] . '" '
                            . 'price="' . $item['price'] . '" '
                            . 'start="' . $item['plan_start'] . '" '
                            . 'end="' . $item['plan_end'] . '" '
                            . 'first-name="' . $item['first_name'] . '" '
                            . 'last-name="' . $item['last_name'] . '" '
                            . 'plan-name="' . $item['plan_name'] . '" '
                            . 'workplace-name="' . $item['workplace_name'] . '" '
                            . 'company="' . $item['company'] . '" '
                            . 'address="' . $item['address'] . '" '
                            . 'locality="' . $item['locality'] . '" '
                            . 'country="' . $item['country'] . '" '
                            . 'days="' . $item['plan_days'] . '" '
                            . 'csm-name="' . CSM_NAME . '" '
                            . 'csm-address="' . CSM_ADDRESS . '" '
                            . 'csm-zipcode="' . CSM_ZIPCODE . '" '
                            . 'csm-locality="' . CSM_LOCALITY . '" '
                            . 'csm-country="' . CSM_COUNTRY . '" '
                            . 'csm-email="' . CSM_EMAIL . '" '
                            . 'csm-website="' . CSM_WEBSITE . '" '
                            . '></invoice>';
                }
            default:
                return $item[$column_name];
        }
    }

    /**
     * Render checkbox column
     * @param type $item
     * @return type
     */
    public function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                /* $1%s */ $this->_args['singular'], //Let's simply repurpose the table's singular label ("movie")
                /* $2%s */ $item['identifier']                //The value of the checkbox should be the record's id
        );
    }

    /**
     * Lastname name column
     * @param type $item
     * @return type
     */
    public function column_last_name($item) {

        //Build row actions
        $actions = array();

        //Return the title contents
        return sprintf('%1$s %2$s',
                /* $1%s */ sprintf('<a class="row-title" href="?page=%s&member_identifier=%s" aria-label="">' . $item['last_name'] . '</a><span style="color:silver">, ' . $item['first_name'] . '</span>', 'csm-member-memberships', $item['member_identifier']),
                /* $2%s */ $this->row_actions($actions)
        );
    }

    /**
     * Identifier column
     * @param type $item
     * @return type
     */
    public function column_identifier($item) {

        //Build row actions
        $actions = array(
            'delete' => sprintf('<a href="?page=%s&action=%s&member_identifier=%s&identifier=%s" onclick="return confirm(\'Are you sure you want to delete membership nr. ' . $item['identifier'] . '?\')">Delete</a>', $_REQUEST['page'], 'delete', $_REQUEST['member_identifier'], $item['identifier']),
        );

        //Return the title contents
        return sprintf('%1$s %2$s',
                /* $1%s */ sprintf('<span class="row-title">' . $item['identifier'] . '</span>', $_REQUEST['page']),
                /* $2%s */ $this->row_actions($actions)
        );
    }

    /**
     * Membership status column
     * @param type $item
     * @return type
     */
    public function column_membership_status($item) {
        if ((strtotime($item['plan_start']) <= time()) && (strtotime($item['plan_end']) > time())) {
            return '<span class="label label-success label-member-active">Active</span>';
        } else if ((strtotime($item['plan_start']) > time()) && (strtotime($item['plan_end']) > time())) {
            return '<span class="label label-info label-member-active">Pending</span>';
        } else {
            return '<span class="label label-default label-member-active" style="display:block">Inactive</span>';
        }
    }

    /**
     * Get columns
     * @return string
     */
    public function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'last_name' => 'Name',
            'identifier' => 'Membership Nr.',
            'membership_status' => 'Status',
            'member_identifier' => 'Plan',
            'plan_start' => 'Starts',
            'plan_end' => 'Expires',
            'payment' => 'Payment',
            'invoice_sent' => 'Invoice Sent'
        );
        return $columns;
    }

    /**
     * Determine with columns are sortable
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'identifier' => array('identifier', false),
            'last_name' => array('last_name', false),
            'membership_status' => array('plan_start', false),
            'member_identifier' => array('member_identifier', false),
            'plan_start' => array('plan_start', false),
            'plan_end' => array('plan_end', false),
            'payment' => array('payment', false),
            'invoice_sent' => array('invoice_sent', false),
        );
        return $sortable_columns;
    }

    /**
     * Bulk actions
     * @return string
     */
    public function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete',
        );
        return $actions;
    }

    /**
     * Process bulk actions
     */
    public function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {

            //Single member delete action
            if (isset($_REQUEST['identifier'])) {
                try {
                    $membership = $this->csmMembership->delete($_REQUEST['identifier']);
                    csm_update($_REQUEST['identifier'] . ' was deleted');
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
            //Delete multiple members
            else {
                try {
                    $res = "";
                    foreach ($_REQUEST['membership'] as $identifier) {
                        $membership = $this->csmMembership->delete($identifier);
                        $res .= $identifier . ' was deleted was deleted<br>';
                    }
                    csm_update($res);
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
        }
    }

    /**
     * Prepare the table
     * @global type $wpdb
     */
    public function prepare_items() {
        global $wpdb;
        $per_page = 30;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $memberships = $this->csmMembership->all(
                (($current_page - 1) * $per_page), $per_page, !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'identifier', !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'DESC', false
        );
        
        $total_items = $this->csmMembership->count();
        $this->items = $memberships;

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}
