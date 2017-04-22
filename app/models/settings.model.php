<?php

class CsmSettings {

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
     * Validate method for create and update
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function validate($data) {
        $data = $this->gump->sanitize($data); // You don't have to sanitize, but it's safest to do so.

        $this->gump->validation_rules(array(
            'csm_name' => 'required|max_len,100',
            'csm_address' => 'required|max_len,100',
            'csm_zipcode' => 'max_len,100',
            'csm_locality' => 'required|max_len,100',
            'csm_country' => 'required|max_len,100',
            'csm_email' => 'required|valid_email',
            'csm_website' => 'max_len,100',
            'csm_currency' => 'max_len,100'
        ));

        $this->gump->filter_rules(array(
            'csm_name' => 'trim|sanitize_string',
            'csm_address' => 'trim|sanitize_string',
            'csm_zipcode' => 'trim|sanitize_string',
            'csm_locality' => 'trim|sanitize_string',
            'csm_country' => 'trim|sanitize_string',
            'csm_email' => 'trim|sanitize_string',
            'csm_website' => 'trim|sanitize_string',
            'csm_currency' => 'trim|sanitize_string'
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
     * Get all Settings
     * @param type $slug
     * @return type
     */
    public function all() {
        $settings = array(
            'csm_logo' => stripslashes(get_option('csm-logo')),
            'csm_name' => stripslashes(get_option('csm-name')),
            'csm_address' => stripslashes(get_option('csm-address')),
            'csm_zipcode' => stripslashes(get_option('csm-zipcode')),
            'csm_locality' => stripslashes(get_option('csm-locality')),
            'csm_country' => stripslashes(get_option('csm-country')),
            'csm_email' => stripslashes(get_option('csm-email')),
            'csm_website' => stripslashes(get_option('csm-website')),
            'csm_currency' => stripslashes(get_option('csm-currency'))
        );
        return $settings;
    }

    /**
     * Update Settings
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function update($data) {
        $data = $this->validate($data);
        update_option('csm-settings-set', true);
        define('CSM_SETTINGS_SET', true);
        
        if (isset($data['csm_logo'])) {
            update_option('csm-logo', $data['csm_logo']);
        }
        
        update_option('csm-name', $data['csm_name']);
        update_option('csm-address', $data['csm_address']);
        update_option('csm-zipcode', $data['csm_zipcode']);
        update_option('csm-locality', $data['csm_locality']);
        update_option('csm-country', $data['csm_country']);
        update_option('csm-email', $data['csm_email']);
        update_option('csm-website', $data['csm_website']);
        update_option('csm-currency', $data['csm_currency']);
    }

}

?>
