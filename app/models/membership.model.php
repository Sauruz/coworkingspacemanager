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
    public function all($offset = 0, $limit = 10, $orderby = 'identifier', $order = 'ASC', $id = false, $plan_start = false, $plan_end = false) {

        $where = "";
        if ($id) {
            $where = "WHERE " . $this->db->prefix . "users.id = '" . $id . "' ";
        }
        if ($plan_start && $plan_end) {
            $where = "WHERE plan_start >= '" . $plan_start . "' AND plan_end <= '" . $plan_end . "' ";
        }

        $query = "SELECT "
                . $this->db->prefix . "csm_memberships.identifier, "
                . $this->db->prefix . "csm_memberships.plan_id, "
                . $this->db->prefix . "csm_memberships.plan_start, "
                . $this->db->prefix . "csm_memberships.plan_end, "
                . $this->db->prefix . "users.ID, "
                . $this->db->prefix . "users.display_name, "
                . $this->db->prefix . "users.user_nicename AS slug, "
                . $this->db->prefix . "users.user_email AS email, "
                . $this->db->prefix . "users.user_registered AS created_at, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'first_name' LIMIT 0,1) AS first_name, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'last_name' LIMIT 0,1) AS last_name, "
                . "(SELECT meta_value FROM " . $this->db->prefix . "usermeta WHERE user_id = " . $this->db->prefix . "users.ID AND meta_key = 'wp_capabilities' LIMIT 0,1) AS roles, "
                . $this->db->prefix . "csm_memberships.approved, "
                . $this->db->prefix . "csm_memberships.payment, "
                . $this->db->prefix . "csm_memberships.payment_method, "
                . $this->db->prefix . "csm_memberships.payment_at, "
                . $this->db->prefix . "csm_memberships.price, "
                . $this->db->prefix . "csm_memberships.vat, "
                . $this->db->prefix . "csm_memberships.price_total, "
                . $this->db->prefix . "csm_memberships.invoice_sent, "
                . $this->db->prefix . "csm_memberships.invoice_sent_at, "
                . $this->db->prefix . "csm_plans.name AS plan_name, "
                . $this->db->prefix . "csm_plans.days AS plan_days, "
                . $this->db->prefix . "csm_workplaces.name AS workplace_name, "
                . $this->db->prefix . "csm_workplaces.color, "
                . $this->db->prefix . "csm_memberships.created_at "
                . "FROM " . $this->db->prefix . "csm_memberships "
                . "INNER JOIN " . $this->db->prefix . "users "
                . "ON " . $this->db->prefix . "csm_memberships.user_id = " . $this->db->prefix . "users.id "
                . "INNER JOIN " . $this->db->prefix . "csm_plans "
                . "ON " . $this->db->prefix . "csm_memberships.plan_id = " . $this->db->prefix . "csm_plans.id "
                . "INNER JOIN " . $this->db->prefix . "csm_workplaces "
                . "ON " . $this->db->prefix . "csm_plans.workplace_id = " . $this->db->prefix . "csm_workplaces.id "
                . $where
                . "ORDER BY " . $orderby . " " . $order . " "
                . "LIMIT " . $offset . "," . $limit;

        $result = $this->db->get_results($query, ARRAY_A);
        foreach ($result as $k => $v) {
            $result[$k]['roles'] = unserialize($v['roles']);
            $result[$k]['avatar_url'] = get_avatar_url($v['email']);
        }
        return $result;
    }

    /**
     * Get single membership
     * @param type $identifier
     * @return type
     */
    public function get($identifier) {
        $query = "SELECT "
                . "* "
                . "FROM " . $this->db->prefix . "csm_memberships "
                . "WHERE identifier = '" . $identifier . "'";
        return $this->db->get_row($query, ARRAY_A);
    }

    /**
     * Check if workplace is available
     * @param type $plan_id
     * @param type $start_date
     * @param type $end_date
     * @return boolean
     * @throws Exception
     */
    public function check_workplace_availability($plan_id, $start_date, $end_date) {

        $plan = $this->csmplan->get($plan_id);
        $datediff = strtotime($end_date) - strtotime($start_date);
        $one_day = 60 * 60 * 24;
        $days = floor($datediff / $one_day);

        $query_count_string = "";
        $dates_arr = array();
        for ($x = 0; $x < $days; $x++) {
            $date = date('Y-m-d', strtotime($start_date) + ($one_day * $x));
            $query_count_string .= "(SELECT count(*) FROM " . $this->db->prefix . "csm_memberships WHERE plan_start <= '$date' AND plan_end > '$date' AND plan_id=$plan_id) AS `$date`, ";
            array_push($dates_arr, $date);
        }

        $query = "SELECT "
                . $query_count_string
                . $this->db->prefix . "csm_workplaces.name AS workplace_name, "
                . $this->db->prefix . "csm_workplaces.capacity "
                . "FROM " .$this->db->prefix . "csm_workplaces "
                . "WHERE " . $this->db->prefix . "csm_workplaces.id = " . $plan['workplace_id'];

        $result = $this->db->get_row($query, ARRAY_A);

        //Check the dates in results
        $is_available = true;
        $not_available_dates = array();
        foreach ($dates_arr as $k => $v) {
            if ($result[$v] >= $result['capacity']) {
                array_push($not_available_dates, $v);
                $is_available = false;
            }
        }

        //Not available string
        if (!$is_available) {
            if (count($not_available_dates) > 5) {
                $errString = $result['workplace_name'] . ' has not enough capacity multiple dates';
            } else {
                $errString = $result['workplace_name'] . ' has not enough capacity on the following dates: ';
                foreach ($not_available_dates as $k => $v) {
                    if ($k === 0) {
                        $errString .= '<span ng-bind="' . $v . ' | date">' . $v . '</span>';
                    } else if ($k === (count($not_available_dates) - 1)) {
                        $errString .= ' and <span ng-bind="' . $v . ' | date">' . $v . '</span>';
                    } else {
                        $errString .= ', <span ng-bind="' . $v . ' | date">' . $v . '</span>';
                    }
                }
            }
            throw new Exception($errString);
        } else {
            return true;
        }
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
            'user_id' => 'required|max_len,100',
            'plan_id' => 'required|numeric',
            'plan_start' => 'required|date',
            'plan_end' => 'required|date',
            'price' => 'required|numeric',
            'vat' => 'numeric',
            'price_total' => 'required|numeric'
        ));

        $this->gump->filter_rules(array(
            'user_id' => 'trim|sanitize_string',
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
            return $data;
        }
    }

    /**
     * Create new membership
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function create($data) {
        $data = $this->validate($data);
        //Check
        $this->check_workplace_availability($data['plan_id'], $data['plan_start'], $data['plan_end']);

        return $this->db->insert($this->db->prefix . "csm_memberships", array(
                    'identifier' => $this->create_identifier(),
                    'user_id' => $data['user_id'],
                    'plan_id' => $data['plan_id'],
                    'plan_start' => $data['plan_start'],
                    'plan_end' => $data['plan_end'],
                    'approved' => $data['approved'] ? 1 : 0,
                    'payment' => $data['payment'] ? 1 : 0,
                    'payment_method' => $data['payment_method'],
                    'payment_at' => $data['payment_at'],
                    'price' => $data['price'],
                    'vat' => $data['vat'],
                    'price_total' => $data['price_total'],
                    'created_at' => current_time('mysql'),
                        )
        );
    }

    /**
     * Register payment
     * @param type $identifier
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function payment($identifier, $data) {
        $data = $this->gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $this->gump->validation_rules(array(
            'identifier' => 'required|max_len,100',
            'payment' => 'required|numeric',
            'payment_method' => 'required',
            'payment_at' => 'required|date',
        ));

        $this->gump->filter_rules(array(
            'identifier' => 'trim|sanitize_string',
            'payment_method' => 'trim|sanitize_string',
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
            $response = $this->db->update($this->db->prefix . "csm_memberships", array(
                'payment' => $data['payment'] ? $data['payment'] : 0,
                'payment_method' => $data['payment_method'] ? $data['payment_method'] : NULL,
                'payment_at' => $data['payment_at'] ? $data['payment_at'] : '0000-00-00 00:00:00',
                'updated_at' => current_time('mysql'),
                    ), array('identifier' => $identifier)
            );
            if ($this->db->last_error) {
                throw new Exception("Something went wrong");
            } else {
                return $response;
            }
        }
    }

    /**
     * Update membership
     * @param type $membership
     * @return type
     */
    public function update($data) {
        $this->gump->validation_rules(array(
            'identifier' => 'required|max_len,100',
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
            $response = $this->db->update($this->db->prefix . "csm_memberships", $data, array('identifier' => $data['identifier'])
            );
            return $response;
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
                'user_id' => 'required|max_len,100',
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
                    'user_id' => $data['user_id'],
                    'plan_id' => $plan['plan_id'],
                    'plan_start' => $data['plan_start'],
                    'plan_end' => date('Y-m-d', (strtotime($data['plan_start']) + ($plan['days'] * 60 * 60 * 24))),
                    'approved' => $data['approved'] ? 1 : 0,
                    'payment' => $data['payment'] ? 1 : 0,
                    'payment_method' => $data['payment_method'],
                    'payment_at' => $data['payment_at'],
                    'price' => $plan['price'],
                    'vat' => $plan['vat'],
                    'price_total' => $plan['price'] + (($plan['price'] / 100) * $data['vat'])
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
     * Delete a membership
     * @param type $identifier
     * @return type
     */
    public function delete($identifier) {
        $membership = $this->db->get_row('SELECT * FROM ' . $this->db->prefix . 'csm_memberships WHERE identifier = "' . $identifier . '"', ARRAY_A);
        if (!empty($membership)) {
            $this->db->delete($this->db->prefix . "csm_memberships", array('identifier' => $identifier));
            return $membership;
        } else {
            throw new Exception("No membership found with number: " . $identifier);
        }
    }

    /**
     * Send mail to owner when new membership is added by user
     * @param type $member
     * @throws Exception
     */
    public function notifyOwner($member) {
        $to = CSM_EMAIL;
        $subject = 'New membership: ' . show_a_name($member);
        $body = 'Hello ' . CSM_NAME . ', <br><br>'
                . show_a_name($member) . ' has added a new membership plan.<br>'
                . 'Login to your Wordpress account and go to the Coworking Space Manager to see the membership plan.';
        $headers = array('Content-Type: text/html; charset=UTF-8',
            'From: ' . html_entity_decode(CSM_NAME) . ' <' . CSM_EMAIL . '>'
        );

        $mail = wp_mail($to, $subject, $body, $headers);
    }

}

?>
