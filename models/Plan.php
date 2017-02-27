<?php

class CsmPlan {

    public $db;
    public $gump;

    function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        /**
         * Use gump library to validate input
         * https://github.com/Wixel/GUMP
         */
        $this->gump = new GUMP();
    }

    /**
     * Get all plans
     * @return type
     */
    public function all() {
        $query = "SELECT "
                . $this->db->prefix . "csm_plans.id as plan_id, "
                . $this->db->prefix . "csm_plans.name as plan_name, "
                . $this->db->prefix . "csm_workplaces.name as workplace_name, "
                . "price, "
                . "days "
                . "FROM " . $this->db->prefix . "csm_plans "
                . "INNER JOIN " . $this->db->prefix . "csm_workplaces "
                . "ON " . $this->db->prefix . "csm_workplaces.id = " . $this->db->prefix . "csm_plans.workplace_id";
        return $this->db->get_results($query, ARRAY_A);
    }

    /**
     * Get single plan
     * @param type $id
     * @return type
     */
    public function get($id) {
        $query = "SELECT "
                . $this->db->prefix . "csm_plans.id as plan_id, "
                . $this->db->prefix . "csm_plans.name as plan_name, "
                . $this->db->prefix . "csm_workplaces.name as workplace_name, "
                . "price, "
                . "days "
                . "FROM " . $this->db->prefix . "csm_plans "
                . "INNER JOIN " . $this->db->prefix . "csm_workplaces "
                . "ON " . $this->db->prefix . "csm_workplaces.id = " . $this->db->prefix . "csm_plans.workplace_id "
                . "WHERE " . $this->db->prefix . "csm_plans.id = " . $id;
        return $this->db->get_row($query, ARRAY_A);
    }

    public function create($data) {
        $data = $this->gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $this->gump->validation_rules(array(
            'name' => 'required|max_len,100',
            'workplace_id' => 'required|numeric',
            'price' => 'required|numeric',
            'days' => 'required|numeric',
        ));

        $this->gump->filter_rules(array(
            'name' => 'trim|sanitize_string',
            'workplace_id' => 'trim|sanitize_string',
            'price' => 'trim|sanitize_string',
            'days' => 'trim|sanitize_string',
        ));

        $validated_data = $this->gump->run($data);
        if ($validated_data === false) {
            $errArr = $this->gump->get_readable_errors();
            $errString = "";
            foreach ($errArr as $k => $err) {
                $errString .= $err . '<br>';
            }
            throw new Exception($errString);
        } else {
            return $this->db->insert($this->db->prefix . "csm_plans", array(
                        'workplace_id' => $data['workplace_id'],
                        'name' => $data['name'],
                        'price' => $data['price'],
                        'days' => $data['days'],
                        'created_at' => current_time('mysql')
                            )
            );
        }
    }

}

?>
