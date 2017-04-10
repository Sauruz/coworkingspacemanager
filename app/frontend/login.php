<?php

$CsmSettings = new CsmSettings();
$data = $CsmSettings->all();

include(CSM_PLUGIN_PATH . 'app/views/frontend/login.view.php');
?>