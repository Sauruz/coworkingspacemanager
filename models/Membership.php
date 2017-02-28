<?php

class CsmMembership {

    private $db;
    private $gump;
    private $csmplan;

    function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->csmplan = new CsmPlan();
        /**
         * Use gump library to validate input
         * https://github.com/Wixel/GUMP
         */
        $this->gump = new GUMP();
    }

    /**
     * Count memberships
     * @return type
     */
    public function count() {
        return $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->prefix . "csm_memberships");
    }

    /**
     * get all Memberships
     * @param type $offset
     * @param type $limit
     * @param type $orderby
     * @param type $order
     * @return type
     */
    public function all($offset = 0, $limit = 10, $orderby = 'last_name', $order = 'ASC', $member_identifier = false) {
        $query = "SELECT "
                . "identifier, "
                . "plan_id, "
                . "plan_start, "
                . "plan_end, "
                . "payment, "
                . "payment_method, "
                . "payment_at, "
                . "price, "
                . "vat, "
                . "price_total, "
                . "invoice_sent, "
                . "created_at "
                . "FROM " . $this->db->prefix . "csm_memberships "
                . "ORDER BY " . $order . " " . $orderby . " "
                . "LIMIT " . $offset . "," . $limit;
        
        echo $query;
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
     * Create new membership plan
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function create($data) {
        $data = $this->gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $this->gump->validation_rules(array(
            'member_identifier' => 'required|max_len,100',
            'plan_id' => 'required|numeric',
            'plan_start' => 'required|date',
            'plan_end' => 'required|date',
            'price' => 'required|numeric',
            'vat' => 'numeric',
            'price_total' => 'required|numeric'
        ));

        $this->gump->filter_rules(array(
            'member_identifier' => 'trim|sanitize_string',
            'plan_id' => 'trim|sanitize_string',
            'plan_start' => 'trim|sanitize_string',
            'plan_end' => 'trim|sanitize_string',
            'price' => 'trim|sanitize_string',
            'vat' => 'trim|sanitize_string',
            'price_total' => 'trim|sanitize_string',
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
            return $this->db->insert($this->db->prefix . "csm_memberships", array(
                        'identifier' => $this->create_identifier(),
                        'member_identifier' => $data['member_identifier'],
                        'plan_id' => $data['plan_id'],
                        'plan_start' => $data['plan_start'],
                        'plan_end' => $data['plan_end'],
                        'price' => $data['price'],
                        'vat' => $data['vat'],
                        'price_total' => $data['price_total'],
                        'created_at' => current_time('mysql'),
                            )
            );
        }
    }

    /**
     * Create a simple membership
     * Only have to give a membership_identifier, plan_id and plan_start
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function create_simple($data) {
        $plan = $this->csmplan->get($data['plan_id']);
        if (empty($plan)) {
            throw new Exception('Something went wrong. Membership plan does not exist');
        } else {
            $this->gump->validation_rules(array(
                'member_identifier' => 'required|max_len,100',
                'plan_id' => 'required|numeric',
                'plan_start' => 'required|date',
                'vat' => 'required|numeric'
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
                $response = $this->create(array(
                    'member_identifier' => $data['member_identifier'],
                    'plan_id' => $plan['plan_id'],
                    'plan_start' => $data['plan_start'],
                    'plan_end' => date('Y-m-d', (strtotime($data['plan_start']) + ($plan['days'] * 60 * 60 * 24))),
                    'price' => $plan['price'],
                    'vat' => $plan['vat'],
                    'price_total' => $plan['price'] + (($plan['price'] / 100) * $plan['vat'])
                ));
                if ($response !== 1) {
                    throw new Exception('Something went wrong');
                } else {
                    return $response;
                }
            }
        }
    }

    /**
     * Create new identifier
     * @return string
     */
    public function create_identifier() {
        $query = "SELECT identifier FROM " . $this->db->prefix . "csm_memberships WHERE identifier LIKE '%" . date('Y') . "%' ORDER BY identifier DESC LIMIT 0,1";
        $new_identifier = date('Y') . '-00001';
        $last_identifier = $this->db->get_var($query);

        if (!empty($last_identifier)) {
            $end = intval(end(explode('-', $last_identifier)));
            $next_number = $end + 1;
            $num_padded = sprintf("%05d", $next_number);
            $new_identifier = date('Y') . '-' . $num_padded;
        }
        return $new_identifier;
    }

    /**
     * Update a member
     * @param type $identifier
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function update($identifier, $data) {
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
