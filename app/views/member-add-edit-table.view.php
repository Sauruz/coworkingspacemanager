<div class="row">
    <div class="col-md-6">
        <label for="first_name"><?php echo __('First Name', 'csm');?> <span class="description">(required)</span></label><br>
        <input name="first_name" class="form-control" placeholder="<?php echo __('First Name', 'csm');?>" type="text" id="first_name" value="<?php form_value($data, 'first_name'); ?>"><br>
    </div>
    <div class="col-md-6">
        <label for="last_name"><?php echo __('Last Name', 'csm');?> <span class="description">(required)</span></label><br>
        <input name="last_name" class="form-control" placeholder="<?php echo __('Last Name', 'csm');?>"  type="text" id="last_name" value="<?php form_value($data, 'last_name'); ?>"><br>
    </div>
</div>
<?php if ($add_password) { ?>
<div class="row">
    <div class="col-md-6">
        <label for="password"><?php echo __('Password', 'csm');?><br>
        <span class="text-danger"><?php echo __('Make sure you give this password to the member', 'csm');?></span>
        <input name="password" class="form-control" type="hidden" id="password" value="<?php echo $data['password']; ?>"><br>
    </div>
    
    <div class="col-md-6">
        <div class="alert alert-success">
            <b style="font-family: courier; color: #000; font-size: 20px;"><?php echo $data['password']; ?></b>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-6">
        <label for="email"><?php echo __('Email', 'csm');?> <span class="description">(required)</span></label><br>
        <input name="email" class="form-control" type="email" placeholder="<?php echo __('Email', 'csm');?> "  id="email" value="<?php form_value($data, 'email'); ?>"><br>
    </div>
    <div class="col-md-6">
        <label for="company"><?php echo __('Company', 'csm');?></label><br>
        <input name="company" class="form-control" type="text" placeholder="<?php echo __('Company', 'csm');?>" id="company" value="<?php form_value($data, 'company'); ?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="address"><?php echo __('Address', 'csm');?></label><br>
        <input name="address" class="form-control" type="text" placeholder="<?php echo __('Address', 'csm');?>" id="address" value="<?php form_value($data, 'address'); ?>"><br>
    </div>
    <div class="col-md-6">
        <label for="locality"><?php echo __('City, State/Province', 'csm');?></label><br>
        <input name="locality" class="form-control" type="text" placeholder="<?php echo __('City, State/Province', 'csm');?>" id="locality" value="<?php form_value($data, 'locality'); ?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="country"><?php echo __('Country', 'csm');?></label><br>
        <input name="country" class="form-control" type="text" placeholder="<?php echo __('Country', 'csm');?>" id="country" value="<?php form_value($data, 'country'); ?>"><br>
    </div>
    <div class="col-md-6">
        <label for="profession"><?php echo __('Profession', 'csm');?></label><br>
        <input name="profession" class="form-control" type="text" placeholder="<?php echo __('Profession', 'csm');?>" id="profession" value="<?php form_value($data, 'profession'); ?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label for="bio"><?php echo __('Bio', 'csm');?></label><br>
        <textarea name="bio" class="form-control" id="bio" placeholder="<?php echo __('Enter a short description', 'csm');?>" rows="6"><?php form_value($data, 'bio'); ?></textarea><br>
    </div>
</div>