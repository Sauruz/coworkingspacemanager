<?php

/**
 * Show overview of membership plans of a member
 */
function show_member_memberships() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    $CsmTemplates = new CsmTemplates();
    $invoiceTemplate = $CsmTemplates->get('invoice');


    if ($_REQUEST['id']) {
        $CsmMember = new CsmMember();
        $member = $CsmMember->get($_REQUEST['id']);
        if (empty($member)) {
            csm_error('No user found with id ' . $_REQUEST['id'], true);
        } else {

            //Update payment status
            if (isset($_POST['action']) && $_POST['action'] === 'addpayment') {
                $CsmMembership = new CsmMembership();
                try {
                    $CsmMembership->payment($_POST['identifier'], $_POST);
                    csm_set_update('Payment status of ' . $_POST['identifier'] . ' has been updated');
                } catch (Exception $e) {
                    csm_error($e->getMessage());
                }
            };

            //Send invoice
            if (isset($_POST['action']) && $_POST['action'] === 'sendinvoice') {
                $CsmInvoice = new CsmInvoice();
                try {
                    $CsmInvoice->send($_POST);
                    csm_set_update('Invoice ' . $_POST['identifier'] . ' has been sent');
                } catch (Exception $e) {
                    csm_error($e->getMessage());
                }
            };

            $data = $member;
            
            $MembershipTable = new MemberMembershipTable();
            //Fetch, prepare, sort, and filter our data...
            $MembershipTable->prepare_items();
            csm_get_update();

            include(CSM_PLUGIN_PATH . 'app/views/member-memberships.view.php');
        }
    } else {
        csm_error('No user id specified', true);
    }
}

?>
