<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('users/create', 'class=form') ?>
  <div class="legend">New User</div>
  <fieldset class="form_fields">
    <label for="first_name">First name:</label>
    <?php echo input_tag('first_name', null, error_class('first_name')) ?><br />
    
    <label for="last_name">Last name:</label>
    <?php echo input_tag('last_name', null, error_class('last_name')) ?><br />

    <label for="email">Email:</label>
    <?php echo input_tag('email', null, error_class('email')) ?><br />

    <label for="phone">Phone:</label>
    <?php echo input_tag('phone', null, error_class('phone')) ?><br />
              
    <label for="username">Username:</label>
    <?php echo input_tag('username', null, error_class('username')) ?><br />
      
    <label for="password">Password:</label>
    <?php echo input_password_tag('password', null, error_class('password')) ?><br />
    
    <label for="password2">Re-enter Password:</label>
    <?php echo input_password_tag('password2', null, error_class('password2')) ?><br />

    <label for="is_enabled">Status:</label>
    <?php echo select_tag('is_enabled', options_for_select(array(1 => 'Enabled', 0 => 'Disabled') , 0)) ?><br />
    
    <label for="user_groups">User Groups:</label>
    <?php echo select_tag('user_groups',
                        objects_for_select($groups, "getId", "getGroupName"),
                        array("multiple" => true, "style" => "height: 150px;")
                       )?><br />
                           
    <label for="must_change_pwd">&nbsp;</label>
    <?php echo checkbox_tag('must_change_pwd', 1, false, 'class=checkbox') ?><var>User must reset password on next log in.</var><br />
  </fieldset>
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'users/list', 'class=button') . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
