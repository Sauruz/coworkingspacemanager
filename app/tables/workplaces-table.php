<?php

class WorkplacesTable extends WP_List_Table {

    private $csmWorkplace;

    /**
     * Construct
     * @global type $status
     * @global type $page
     */
    public function __construct() {
        global $status, $page;

        $this->csmWorkplace = new CsmWorkplace();
        //Set parent defaults
        parent::__construct(array(
            'singular' => 'workplace', //singular name of the listed records
            'plural' => 'workplaces', //plural name of the listed records
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
            case 'capacity':
                return '<div class="days-circle">' . $item['capacity'] . '</div>';
                case 'color':
                return '<div class="color-circle" style="background-color: ' . $item['color'] .';"></div>';
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
                /* $2%s */ $item['id']                //The value of the checkbox should be the record's id
        );
    }

    /**
     * Mame column
     * @param type $item
     * @return type
     */
    public function column_name($item) {
        //Build row actions
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&id=%s">Edit</a>', 'csm-workplace-edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s" onclick="return confirm(\'Are you sure you want to delete ' . $item['name'] . '?\')">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );

        //Return the title contents
        return sprintf('%1$s %2$s',
                /* $1%s */ sprintf('<a class="row-title" href="?page=%s&id=%s" aria-label="">' . $item['name'] . '</a>', 'csm-workplace-edit', $item['id']),
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
            'name' => 'Workplace',
            'capacity' => 'Capacity',
            'color' => 'Calendar Background'
        );
        return $columns;
    }

    /**
     * Determine with columns are sortable
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array('name', false),
            'capacity' => array('capacity', false),
            'color' => array('color', false),
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
                    $workplace = $this->csmWorkplace->delete($_REQUEST['id']);
                    csm_update($workplace['name'] . ' was deleted');
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
            //Delete multiple members
            else {
                try {
                    $res = "";
                    foreach ($_REQUEST['workplace'] as $id) {
                        $workplace = $this->csmWorkplace->delete($id);
                        $res .= $workplace['name'] . ' was deleted<br>';
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

        $plans = $this->csmWorkplace->all(
                (($current_page - 1) * $per_page), $per_page, !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'ASC', !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'name'
        );
        $total_items = $this->csmWorkplace->count();
        $this->items = $plans;

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}
