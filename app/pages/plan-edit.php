<?php

/**
 * Show page to edit plan
 */
function show_plan_edit() {
    //must check that the user has the required capability 
    if (!current_user_can('manage_options')) {
        csm_error('You do not have sufficient permissions to access this page', true);
    }

    if ($_REQUEST['id']) {
        $CsmPlan = new CsmPlan();
        $plan = $CsmPlan->get($_REQUEST['id']);
        if (empty($plan)) {
            csm_error('No plan found with id ' . $_REQUEST['id'], true);
        } else {
            $data = $plan;
            $data['name'] = $plan['plan_name'];
            
            $CsmWorkplace = new CsmWorkplace();
            $workplaces = $CsmWorkplace->all();

            //Add the member
            if (isset($_POST['action']) && $_POST['action'] === 'editplan') {
                $data = $_POST;
                $Csmplan = new CsmPlan();
                try {
                    $Csmplan->update($_POST, $_REQUEST['id']);
                    csm_set_update('Membership plan was updated');
                    hacky_redirect('csm-plans');
                } catch (\Exception $e) {
                    csm_error($e->getMessage());
                }
            }
            include(CSM_PLUGIN_PATH . 'app/views/plan-edit.view.php');
        }
    } else {
        csm_error('No plan id specified', true);
    }
}
