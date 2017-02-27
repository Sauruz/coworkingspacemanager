<?php

if ($_REQUEST['identifier']) {
    $CsmMember = new CsmMember();
    $member = $CsmMember->get($_REQUEST['identifier']);
    if (empty($member)) {
        csm_error('No user found with identifier ' . $_REQUEST['identifier'], true);
    } else {
        $data = $member;

        //Edit the member
        if (isset($_POST['action']) && $_POST['action'] === 'editmember') {
            $data = $_POST;
            $CsmMember = new CsmMember;
            try {
                $CsmMember->update($member['identifier'], $_POST);
                csm_set_update($_POST['first_name'] . ' '  .$_POST['last_name'] . ' was updated');
                 hacky_redirect();
            } catch (\Exception $e) {
                csm_error($e->getMessage());
            }
        }
        include(CSM_PLUGIN_PATH . 'views/backend/member-edit.view.php');
    }
} else {
    csm_error('No identifier specified', true);
}
?>
