<?php

class CsmWorkplace {

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
    public function all($offset = 0, $limit = 10, $order = 'ASC',$orderby = 'name') {
        $query = "SELECT * "
                . "FROM " . $this->db->prefix . "csm_workplaces "
                . "ORDER BY " . $orderby . " " . $order . " "
                . "LIMIT " . $offset . "," . $limit;
        
        return $this->db->get_results($query, ARRAY_A);
    }
    
    /**
     * Count Plans
     * @return type
     */
    public function count() {
        return $this->db->get_var("SELECT COUNT(*) FROM " . $this->db->prefix . "csm_workplaces");
    }
    
    /**
     * Add a desk
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function create($data) {
        $data = $this->gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $this->gump->validation_rules(array(
            'name' => 'required|max_len,100',
            'capacity' => 'required|numeric',
        ));

        $this->gump->filter_rules(array(
            'name' => 'trim|sanitize_string',
            'capacity' => 'trim|sanitize_string',
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
            return $this->db->insert($this->db->prefix . "csm_workplaces", array(
                        'name' => $data['name'],
                        'capacity' => $data['capacity'],
                        'created_at' => current_time('mysql')
                            )   
            );
        }
    }
}

?>
