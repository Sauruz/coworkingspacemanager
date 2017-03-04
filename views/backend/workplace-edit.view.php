<div class="wrap">
    <h1 class="wp-heading-inline"><strong>Add Workplace</strong></h1>

    <div class="bootstrap-wrapper">
        <?php include CSM_PLUGIN_PATH . 'views/backend/tabbar/workplaces.tabbar.php'; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" method="post">
                            <input name="action" type="hidden" value="editworkplace">
                                
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">Name of the workplace <span class="description">(required)</span></label><br>
                                    <input name="name" class="form-control" placeholder="eg. Hot Desk, Private Office, Shed, etc." type="text" id="name" value="<?php form_value($data, 'name'); ?>"><br>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="capacity">Capacity <span class="description">(required)</span></label><br>
                                    <input name="capacity" class="form-control" placeholder="Capacity" type="number" min="1" id="capacity" value="<?php form_value($data, 'capacity'); ?>"><br>
                                </div>
                                 <div class="col-md-6">
                                    <label for="color">Calendar background <span class="description">(required)</span></label><br>
                                     <select name="color" id="color" class="form-control">
                                        <?php
                                        foreach ($colors as $k => $v) {
                                            $selected = isset($data['color']) && $data['color'] === $k ? 'selected' : '';
                                            echo '<option value="' . $k . '" style="background: ' . $v . '"; ' . $selected . '>' . $v . '</option>';
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>
                            <p class="submit">
                                <input type="submit"class="btn btn-primary btn-block" value="Edit Workplace">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>