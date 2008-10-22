<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('users/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($user, 'getId', 'class=hidden') ?>
  <div class="legend">Editing User: <?php echo $user->getUsername() ?></div>
  <fieldset class="form_fields">
    
    <label for="first_name">First Name:</label>
    <?php echo object_input_tag($user, 'getFirstName', error_class('first_name')) ?><br />
    
    <label for="last_name">Last Name:</label>
    <?php echo object_input_tag($user, 'getLastName', error_class('last_name')) ?><br />

    <label for="email">Email:</label>
    <?php echo object_input_tag($user, 'getEmail', error_class('email')) ?><br />
          
    <label for="phone">Phone:</label>
    <?php echo object_input_tag($user, 'getPhone', error_class('phone')) ?><br />
              
    <label for="password">Password:</label>
    <?php echo input_password_tag('getPassword', null, error_class('password')) ?><br />
    
    <label for="password2">Re-enter Password:</label>
    <?php echo input_password_tag('password2', null, error_class('password2')) ?><br />
        
    <label for="is_enabled">Status:</label>
    <?php echo select_tag('is_enabled', options_for_select(array(1 => 'Enabled', 0 => 'Disabled'), (int) $user->getIsEnabled())) ?><br />
    
    <label for="user_groups">User Groups:</label>
    <?php echo select_tag('user_groups',
                        objects_for_select($groups, "getId", "getGroupName", $user_groups),
                        array("multiple" => true, "style" => "height: 150px;")
                       )?><br />
                       
    <label for="must_change_pwd">&nbsp;</label>
    <?php echo object_checkbox_tag($user, 'getMustChangePwd', 'class=checkbox') ?><var>User must reset password on next log in.</var><br />
                           
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'users/list')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
