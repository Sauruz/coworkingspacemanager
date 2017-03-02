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
    public function all($offset = 0, $limit = 10, $order = 'ASC', $orderby = 'plan_name') {
        $query = "SELECT "
                . $this->db->prefix . "csm_plans.id as plan_id, "
                . $this->db->prefix . "csm_plans.name as plan_name, "
                . $this->db->prefix . "csm_workplaces.name as workplace_name, "
                . "price, "
                . "days "
                . "FROM " . $this->db->prefix . "csm_plans "
                . "INNER JOIN " . $this->db->prefix . "csm_workplaces "
                . "ON " . $this->db->prefix . "csm_workplaces.id = " . $this->db->prefix . "csm_plans.workplace_id "
                . "ORDER BY " . $orderby . " " . $order . " "
                . "LIMIT " . $offset . "," . $limit;
        return $this->db->get_results($query, ARRAY_A);
    }

    /**
     * Count Plans
     * @return type
     */
    public function count() {
        return $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->prefix . "csm_plans");
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
                . $this->db->prefix . "csm_workplaces.id as workplace_id, "
                . $this->db->prefix . "csm_workplaces.name as workplace_name, "
                . "price, "
                . "days "
                . "FROM " . $this->db->prefix . "csm_plans "
                . "INNER JOIN " . $this->db->prefix . "csm_workplaces "
                . "ON " . $this->db->prefix . "csm_workplaces.id = " . $this->db->prefix . "csm_plans.workplace_id "
                . "WHERE " . $this->db->prefix . "csm_plans.id = " . $id;
        return $this->db->get_row($query, ARRAY_A);
    }

    /**
     * Create a plan
     * @param type $data
     * @return type
     * @throws Exception
     */
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

    /**
     * Update a plan
     * @param type $data
     * @param type $id
     * @return type
     * @throws Exception
     */
    public function update($data, $id) {
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
            $this->db->update($this->db->prefix . "csm_plans", array(
                'workplace_id' => $data['workplace_id'],
                'name' => $data['name'],
                'price' => $data['price'],
                'days' => $data['days']
                    ), array('id' => $id)
            );
            if ($this->db->last_error) {
                throw new Exception('Something went wrong');
            } else {
                return $data;
            }
        }
    }

    /**
     * Delete a plan
     * A plan cannot be deleted if a membership has this plan
     * @param type $identifier
     * @return type
     */
    public function delete($id) {
        $plan = $this->get($id);
        if (!empty($plan)) {

            $this->db->delete($this->db->prefix . "csm_plans", array('id' => $id));
            if ($this->db->last_error) {
                throw new Exception("Can not delete " . $plan['workplace_name'] . '  &bull; ' . $plan['plan_name'] . ". "
                . "One or more members are using this plan. "
                . "Delete these membership plans first, before deleting the plan.");
            } else {
                return $plan;
            }
        } else {
            throw new Exception("No plan found with id: " . $id);
        }
    }

}

?>
