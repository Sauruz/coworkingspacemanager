<div class="row">
    <div class="col-md-12">
        <label for="first_name">First Name <span class="description">(required)</span></label><br>
        <input name="first_name" class="form-control" placeholder="First Name" type="text" id="first_name" value="<?php form_value($data, 'first_name'); ?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label for="last_name">Last Name <span class="description">(required)</span></label><br>
        <input name="last_name" class="form-control" placeholder="Last Name"  type="text" id="last_name" value="<?php form_value($data, 'last_name'); ?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label for="email">Email <span class="description">(required)</span></label><br>
        <input name="email" class="form-control" type="email" placeholder="Email"  id="email" value="<?php form_value($data, 'email'); ?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label for="profession">Profession</label><br>
        <input name="profession" class="form-control" type="text" placeholder="Profession" id="profession" value="<?php form_value($data, 'profession'); ?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label for="bio">Bio</label><br>
        <textarea name="bio" class="form-control" id="bio" placeholder="Enter a short description" rows="6"><?php form_value($data, 'bio'); ?></textarea><br>
    </div>
</div>