<?php
/**
 * Show page to edit workplace
 */
function show_workplace_edit() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    if ($_REQUEST['id']) {
        $CsmWorkplace = new CsmWorkplace();
        $workplace = $CsmWorkplace->get($_REQUEST['id']);
        if (empty($workplace)) {
            csm_error('No workplace found with id ' . $_REQUEST['id'], true);
        } else {
            $data = $workplace;

            //Edit workplace
            if (isset($_POST['action']) && $_POST['action'] === 'editworkplace') {
                $data = $_POST;
                try {
                    $CsmWorkplace->update($_POST, $_REQUEST['id']);
                    csm_set_update($workplace['name'] . ' was updated');
                    hacky_redirect('csm-workplaces');
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }

            include(CSM_PLUGIN_PATH . 'app/assets/colors.php');
            include(CSM_PLUGIN_PATH . 'app/views/workplace-edit.view.php');
        }
    } else {
        csm_error('No workplace id specified', true);
    }
}
