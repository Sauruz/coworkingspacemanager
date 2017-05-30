<?php

class CsmInvoice {

    public $db;
    public $gump;

    function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->cmsMembership = new CsmMembership();
        $this->cmsMember = new CsmMember();
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

        $this->gump->validation_rules(array(
            'identifier' => 'required|max_len,100',
            'id' => 'required|numeric|max_len,100',
            'invoice' => 'required'
        ));

        $this->gump->filter_rules(array(
            'identifier' => 'trim|sanitize_string',
            'id' => 'trim|sanitize_string'
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
     * Get all Invoices
     * @param type $slug
     * @return type
     */
    public function all() {
        
    }
    
    
    public function createInvoicePdf() {
        
    }

    /**
     * Send invoice
     * @param type $data
     * @return type
     * @throws Exception
     */
    public function send($data) {
        $data = $this->validate($data);

        $membership = $this->cmsMembership->get($data['identifier']);
        if (empty($membership)) {
            throw new Exception('Something went wrong. Member does not exist');
        } else {
            $member = $this->cmsMember->get($membership['user_id']);

            $to = $member['email'];
            $subject = 'Invoice nr: ' . $membership['identifier'];
            $body = $data['invoice'];
            $headers = array('Content-Type: text/html; charset=UTF-8',
                'From: ' . CSM_NAME . ' <' . CSM_EMAIL . '>'
            );

            $membership['invoice_sent'] = 1;
            $membership['invoice'] = $data['invoice'];
            $membership['invoice_sent_at'] = current_time('mysql');
            $membership['updated_at'] = current_time('mysql');
            $this->cmsMembership->update($membership);

//            $mail = wp_mail($to, $subject, $body, $headers);
//            if ($mail) {
//                $membership['invoice_sent'] = 1;
//                $membership['invoice'] = $data['invoice'];
//                $membership['invoice_sent_at'] = current_time('mysql');
//                $membership['updated_at'] = current_time('mysql');
//                $this->cmsMembership->update_invoice($membership);
//            } else {
//                throw new Exception('Invoice was not send. Please check your Wordpress email settings.');
//            }
        }
    }

}

?>
