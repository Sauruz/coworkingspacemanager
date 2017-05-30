<?php

class CsmTemplates {

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
     * Get a template
     * @param type $slug
     * @return type
     */
    public function get($slug) {
        $query = "SELECT "
                . "name, "
                . "slug, "
                . "template "
                . "FROM " . $this->db->prefix . "csm_templates "
                . "WHERE slug = '" . $slug . "'";
        return $this->db->get_row($query, ARRAY_A);
    }
}

?>
