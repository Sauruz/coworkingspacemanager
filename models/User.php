<?php

class CsmUser {

    function __construct() {
        global $wpdb;
        $this->db = $wpdb;
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
                . "description, "
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
        $user = $this->db->get_row('SELECT * FROM ' . $this->db->prefix . 'csm_members WHERE email="' . $data['email'] . '"', ARRAY_A);
        if (empty($user)) {
            return $this->db->insert($this->db->prefix . "csm_members", array(
                'identifier' => uniqid() . '_' . substr(strtolower(preg_replace("/(\W)+/", "",$data['last_name'])), 0, 15),
                'first_name' => trim($data['first_name']),
                'last_name' => trim($data['last_name']),
                'email' => trim($data['email']),
                'description' => trim($data['description']),
                'profession' => trim($data['profession']),
                'photo' => trim($data['photo']),
                'created_at' => current_time('mysql'),
                    )
            );
        } else {
            throw new Exception("Email already exist");
        }
    }
}
?>
