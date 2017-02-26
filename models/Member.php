<?php

class CsmMember {

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
    public function all($offset = 0, $limit = 10, $orderby = 'last_name', $order = 'ASC') {
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
                . "ORDER BY " . $order . " " . $orderby . " "
                . "LIMIT " . $offset . "," . $limit;
        return $this->db->get_results($query, ARRAY_A);
    }

    /**
     * Create new user
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function create($data) {
        $data = $this->gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $this->gump->validation_rules(array(
            'first_name' => 'required|alpha_numeric|max_len,100',
            'last_name' => 'required|alpha_numeric|max_len,100',
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
            foreach($errArr as $k => $err) {
                $errString .= ' - ' . $err . '<br>';
            }
            throw new Exception($errString);
        } else {
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
    }

}

?>
