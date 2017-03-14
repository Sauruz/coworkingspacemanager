<?php

class PlansTable extends WP_List_Table_Custom {

    private $csmPlan;

    /**
     * Construct
     * @global type $status
     * @global type $page
     */
    public function __construct() {
        global $status, $page;

        $this->csmPlan = new CsmPlan();
        //Set parent defaults
        parent::__construct(array(
            'singular' => 'plan', //singular name of the listed records
            'plural' => 'plans', //plural name of the listed records
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
            case 'price':
                return '<span ng-bind="' . $item['price'] . ' | currency : \'' . CSM_CURRENCY_SYMBOL . '\'">' . CSM_CURRENCY_SYMBOL . $item['price'] . '</span>';
            case 'days':
                return '<div class="days-circle">' . $item['days'] . '</div>';
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
                /* $2%s */ $item['plan_id']                //The value of the checkbox should be the record's id
        );
    }

    /**
     * Workplace name
     * @param type $item
     * @return type
     */
    public function column_workplace_name($item) {
        //Build row actions
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&id=%s">Edit</a>', 'csm-plan-edit', $item['plan_id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s" onclick="return confirm(\'Are you sure you want to delete ' . $item['workplace_name'] . '  &bull; ' . $item['plan_name'] . '?\')">Delete</a>', $_REQUEST['page'], 'delete', $item['plan_id']),
        );

        //Return the title contents
        return sprintf('%1$s %2$s',
                /* $1%s */ sprintf('<a class="row-title" href="?page=%s&id=%s" aria-label="">' . $item['workplace_name'] . '  &bull; ' . $item['plan_name'] . '</a>', 'csm-plan-edit', $item['plan_id']),
                /* $2%s */ $this->row_actions($actions)
        );
    }

    /**
     * Get columns
     * @return string
     */
    public function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'workplace_name' => 'Plan',
            'days' => 'Days',
            'price' => 'Price',
        );
        return $columns;
    }

    /**
     * Determine with columns are sortable
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'last_name' => array('last_name', false),
            'workplace_name' => array('workplace_name', false),
            'days' => array('days', false),
            'price' => array('price', false),
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
            if (isset($_REQUEST['id'])) {
                try {
                    $plan = $this->csmPlan->delete($_REQUEST['id']);
                    csm_update($plan['workplace_name'] . '  &bull; ' . $plan['plan_name'] . ' was deleted');
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
            //Delete multiple members
            else {
                try {
                    $res = "";
                    foreach ($_REQUEST['plan'] as $id) {
                        $plan = $this->csmPlan->delete($id);
                        $res .= $plan['workplace_name'] . ' &bull; ' . $plan['plan_name'] . ' was deleted<br>';
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

        $plans = $this->csmPlan->all(
                (($current_page - 1) * $per_page), $per_page, !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'ASC', !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'workplace_name'
        );
        $total_items = $this->csmPlan->count();
        $this->items = $plans;

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}
