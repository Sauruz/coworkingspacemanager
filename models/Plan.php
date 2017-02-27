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
                . "FROM " . $this->db->prefix . "csm_plans ";
        return $this->db->get_results($query, ARRAY_A);
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
