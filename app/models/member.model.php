<?php

class CsmMember {

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
     * Count users
     * @return type
     */
    public function count() {
        return $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->prefix . "csm_members");
    }

    /**
     * get all users
     * @param type $offset
     * @param type $limit
     * @param type $orderby
     * @param type $order
     * @return type
     */
    public function all($offset = 0, $limit = 10, $orderby = 'last_name', $order = 'ASC', $search = false) {
        
        $extra_where = "";
        if ($search) {
            $extra_where = "WHERE " . $this->db->prefix . "csm_members.first_name LIKE '%" . $search . "%' OR " . $this->db->prefix . "csm_members.last_name LIKE '%" . $search . "%' ";
        }
        
        $query = "SELECT "
                . "identifier, "
                . "first_name, "
                . "last_name, "
                . "email, "
                . "profession, "
                . "bio, "
                . "photo, "
                . "plan_id, "
                . "plan, "
                . "plan_price, "
                . "plan_days, "
                . "plan_start, "
                . "plan_end, "
                . "workplace, "
                . "workplace_capacity, "
                . "(SELECT count(*) FROM " . $this->db->prefix . "csm_memberships WHERE member_identifier = " . $this->db->prefix . "csm_members.identifier AND payment = 0) AS payments_open, "
                . "(SELECT count(*) FROM " . $this->db->prefix . "csm_memberships WHERE member_identifier = " . $this->db->prefix . "csm_members.identifier AND invoice_sent = 0) AS invoices_open,"
                . "created_at "
                . "FROM " . $this->db->prefix . "csm_members "
                . "LEFT JOIN "
                . "(SELECT "
                . "member_identifier, "
                . "plan_id, "
                . $this->db->prefix . "csm_plans.name as plan, "
                . $this->db->prefix . "csm_plans.price as plan_price, "
                . $this->db->prefix . "csm_plans.days as plan_days, "
                . $this->db->prefix . "csm_workplaces.name as workplace, "
                . $this->db->prefix . "csm_workplaces.capacity as workplace_capacity, "
                . "plan_start, "
                . "plan_end "
                . "FROM " . $this->db->prefix . "csm_memberships "
                . "INNER JOIN " . $this->db->prefix . "csm_plans "
                . "ON " . $this->db->prefix . "csm_memberships.plan_id = " . $this->db->prefix . "csm_plans.id "
                . "INNER JOIN " . $this->db->prefix . "csm_workplaces "
                . "ON " . $this->db->prefix . "csm_plans.workplace_id = " . $this->db->prefix . "csm_workplaces.id "
                . "WHERE plan_end > CURDATE() "
                . "ORDER BY plan_end DESC) ms "
                . "ON (identifier = ms.member_identifier) "
                . $extra_where
                . "GROUP BY identifier "
                . "ORDER BY " . $orderby . " " . $order. " "
                . "LIMIT " . $offset . "," . $limit;
        return $this->db->get_results($query, ARRAY_A);
    }
    
    /**
     * Get users for ajax
     * @param type $offset
     * @param type $limit
     * @param type $orderby
     * @param type $order
     * @return type
     */
    public function ajax($offset = 0, $limit = 1000000, $orderby = 'last_name', $order = 'ASC') { 
        $query = "SELECT "
                . "identifier, "
                . "first_name, "
                . "last_name "
                . "FROM " . $this->db->prefix . "csm_members "
                . "ORDER BY " . $orderby. " " . $order  . " "
                . "LIMIT " . $offset . "," . $limit;
        
        return $this->db->get_results($query, ARRAY_A);
    }

    /**
     * Get single member
     * @param type $identifier
     * @return type
     */
    public function get($identifier) {
        $query = "SELECT "
                . "identifier, "
                . "first_name, "
                . "last_name, "
                . "email, "
                . "profession, "
                . "bio, "
                . "photo, "
                . "created_at "
                . "FROM " . $this->db->prefix . "csm_members "
                . "WHERE identifier = '" . $identifier . "'";
        return $this->db->get_row($query, ARRAY_A);
    }

    /**
     * Validate method for create and update
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function validate($data) {
        $data = $this->gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $this->gump->validation_rules(array(
            'first_name' => 'required|max_len,100',
            'last_name' => 'required|max_len,100',
            'email' => 'required|valid_email'
        ));

        $this->gump->filter_rules(array(
            'first_name' => 'trim|sanitize_string',
            'last_name' => 'trim|sanitize_string',
            'email' => 'trim|sanitize_email',
            'profession' => 'trim|sanitize_string',
            'bio' => 'trim|sanitize_string'
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
            return $data;
        }
    }

    /**
     * Create new member
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function create($data) {
        $data = $this->validate($data);
        $user = $this->db->get_row('SELECT * FROM ' . $this->db->prefix . 'csm_members WHERE email="' . $data['email'] . '"', ARRAY_A);
        if (empty($user)) {
            return $this->db->insert($this->db->prefix . "csm_members", array(
                        'identifier' => uniqid() . '_' . substr(strtolower(preg_replace("/(\W)+/", "", $data['last_name'])), 0, 15),
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'bio' => $data['bio'],
                        'profession' => $data['profession'],
                        'photo' => $data['photo'],
                        'created_at' => current_time('mysql'),
                            )
            );
        } else {
            throw new Exception("Email already exist");
        }
    }

    /**
     * Update a member
     * @param type $identifier
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function update($identifier, $data) {
        $data = $this->validate($data);
        $user = $this->db->get_row('SELECT * FROM ' . $this->db->prefix . 'csm_members WHERE email="' . $data['email'] . ' AND identifier != "' . $identifier . '"', ARRAY_A);
        if (empty($user)) {
            return $this->db->update($this->db->prefix . "csm_members", array(
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'bio' => $data['bio'],
                        'profession' => $data['profession'],
                        'photo' => $data['photo'],
                        'created_at' => current_time('mysql'),
                            ), array('identifier' => $identifier)
            );
        } else {
            throw new Exception("Email already exist");
        }
    }

    /**
     * Delete a member
     * @param type $identifier
     * @return type
     */
    public function delete($identifier) {
        $member = $this->db->get_row('SELECT * FROM ' . $this->db->prefix . 'csm_members WHERE identifier = "' . $identifier . '"', ARRAY_A);
        if (!empty($member)) {
            $this->db->delete($this->db->prefix . "csm_members", array('identifier' => $identifier));
            return $member;
        } else {
            throw new Exception("No member found with identifier: " . $identifier);
        }
    }

}

?>
