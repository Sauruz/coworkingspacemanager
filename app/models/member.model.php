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
                . $this->db->prefix . "users.ID, "
                . $this->db->prefix . "users.display_name, "
                . $this->db->prefix . "users.user_nicename AS slug, "
                . $this->db->prefix . "users.user_email AS email, "
                . $this->db->prefix . "users.user_registered AS created_at, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'first_name' LIMIT 0,1) AS first_name, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'last_name' LIMIT 0,1) AS last_name, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'wp_capabilities' LIMIT 0,1) AS roles, "
                . "ms.plan_id, "
                . "ms.plan, "
                . "ms.plan_price, "
                . "ms.plan_days, "
                . "ms.plan_start, "
                . "ms.plan_end, "
                . "ms.workplace, "
                . "ms.workplace_capacity, "
                . "(SELECT count(*) FROM " . $this->db->prefix . "csm_memberships WHERE user_id = " . $this->db->prefix . "users.ID AND payment = 0) AS payments_open, "
                . "(SELECT count(*) FROM " . $this->db->prefix . "csm_memberships WHERE user_id = " . $this->db->prefix . "users.ID AND invoice_sent = 0) AS invoices_open "
                . "FROM " . $this->db->prefix . "users "
                . "LEFT JOIN "
                . "	(SELECT "
                . "		" . $this->db->prefix . "csm_memberships.user_id, "
                . "		" . $this->db->prefix . "csm_memberships.plan_id, "
                . "		" . $this->db->prefix . "csm_plans.name as plan, "
                . "		" . $this->db->prefix . "csm_plans.price as plan_price, "
                . "		" . $this->db->prefix . "csm_plans.days as plan_days, "
                . "		" . $this->db->prefix . "csm_workplaces.name as workplace, "
                . "		" . $this->db->prefix . "csm_workplaces.capacity as workplace_capacity, "
                . "		plan_start, plan_end "
                . "		FROM " . $this->db->prefix . "csm_memberships "
                . "		INNER JOIN " . $this->db->prefix . "csm_plans ON " . $this->db->prefix . "csm_memberships.plan_id = " . $this->db->prefix . "csm_plans.id "
                . "		INNER JOIN " . $this->db->prefix . "csm_workplaces ON " . $this->db->prefix . "csm_plans.workplace_id = " . $this->db->prefix . "csm_workplaces.id "
                . "		WHERE plan_end > CURDATE() "
                . "		ORDER BY plan_end DESC"
                . "		) ms "
                . "ON (ID = ms.user_id) "
                . $extra_where
                . "GROUP BY " . $this->db->prefix . "users.ID "
                . "ORDER BY " . $orderby . " " . $order . " "
                . "LIMIT " . $offset . "," . $limit;


        $result = $this->db->get_results($query, ARRAY_A);
        foreach ($result as $k => $v) {
            $result[$k]['roles'] = unserialize($v['roles']);
        }
        return $result;
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
                . "ID, "
                . "display_name, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'first_name' LIMIT 0,1) AS first_name, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'last_name' LIMIT 0,1) AS last_name "
                . "FROM " . $this->db->prefix . "users "
                . "ORDER BY " . $orderby . " " . $order . " "
                . "LIMIT " . $offset . "," . $limit;

        return $this->db->get_results($query, ARRAY_A);
    }

    /**
     * Get single member
     * @param type $id
     * @return type
     */
    public function get($id) {
        $query = "SELECT "
                . "id, "
                . "display_name, "
                . "user_email AS email, "
                . meta_user_query($this->db->prefix, $id, 'wp_capabilities', true, 'roles')
                . meta_user_query($this->db->prefix, $id, 'first_name', true)
                . meta_user_query($this->db->prefix, $id, 'user_company', true, 'company')
                . meta_user_query($this->db->prefix, $id, 'user_address', true, 'address')
                . meta_user_query($this->db->prefix, $id, 'user_locality', true, 'locality')
                . meta_user_query($this->db->prefix, $id, 'user_country', true, 'country')
                . meta_user_query($this->db->prefix, $id, 'user_profession', true, 'profession')
                . meta_user_query($this->db->prefix, $id, 'description', true, 'bio')
                . meta_user_query($this->db->prefix, $id, 'last_name', false)
                . "FROM " . $this->db->prefix . "users "
                . "WHERE id = " . $id;
        $user = $this->db->get_row($query, ARRAY_A);
        $user['roles'] = unserialize($user['roles']);
        return $user;
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
            'company' => 'trim|sanitize_string',
            'address' => 'trim|sanitize_string',
            'locality' => 'trim|sanitize_string',
            'country' => 'trim|sanitize_string',
            'profession' => 'trim|sanitize_string',
            'bio' => 'trim|sanitize_string',
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
        $user = $this->db->get_row('SELECT * FROM ' . $this->db->prefix . 'users WHERE user_email="' . $data['email'] . '"', ARRAY_A);
        if (empty($user)) {
            $userdata = array(
                'user_login' => $data['email'],
                'user_pass' => $data['password'],
                'user_email' => $data['email'],
                'display_name' => $data['first_name'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'description' => $data['bio'],
                'role' => 'csm_member'
            );
            $id = wp_insert_user($userdata);
            $this->addMeta($id, $data);
        } else {
            throw new Exception("Email already exist");
        }
    }

    /**
     * Update a member
     * @param type $id
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function update($id, $data) {
        $data = $this->validate($data);
        $user = $this->db->get_row('SELECT * FROM ' . $this->db->prefix . 'users WHERE email="' . $data['email'] . ' AND id != ' . $id . '', ARRAY_A);
        if (empty($user)) {


            wp_update_user(array(
                'ID' => $id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'user_email' => $data['email'],
                'display_name' => $data['first_name'],
                'nickname' => $data['nickname'],
                'description' => $data['bio'],
            ));

            $this->addMeta($id, $data);
        } else {
            throw new Exception("Email already exist");
        }
    }

    public function addMeta($id, $data) {
        if (!empty($data['company'])) {
            update_user_meta($id, 'user_company', $data['company']);
        }

        if (!empty($data['address'])) {
            update_user_meta($id, 'user_address', $data['address']);
        }

        if (!empty($data['locality'])) {
            update_user_meta($id, 'user_locality', $data['locality']);
        }

        if (!empty($data['country'])) {
            update_user_meta($id, 'user_country', $data['country']);
        }

        if (!empty($data['bio'])) {
            update_user_meta($id, 'description', $data['bio']);
        }

        if (!empty($data['profession'])) {
            update_user_meta($id, 'user_profession', $data['profession']);
        }
    }

    /**
     * Delete a member
     * @param type $identifier
     * @return type
     */
    public function delete($id) {
        $member = $this->get($id);
        if (!empty($member)) {
            //do not delete administrators
            if (isset($member['roles']['administrator']) && $member['roles']['administrator'] == '1') {
                throw new Exception("Can't delete " . $member['display_name'] . ' because deleting administrators is not allowed.');
            } else {
                wp_delete_user($id);
                return $member;
            }
        } else {
            throw new Exception("No member found with id: " . $id);
        }
    }

}

?>
