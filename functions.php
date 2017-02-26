<?php

/**
 * Set a default form value
 * @param type $val
 */
function form_value($val) {
    $res = !empty($_POST[$val]) ? $_POST[$val] : "";
    echo $res;
}


?>
