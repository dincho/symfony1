<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('users/create', 'class=form') ?>
  <div class="legend">New User</div>
  <fieldset class="form_fields float-right" style="margin-right: 200px">
    <label for="dashboard_mod">Dashboard:</label>
    <?php echo checkbox_tag('dashboard_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('dashboard_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('dashboard_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="members_mod">Members:</label>
    <?php echo checkbox_tag('members_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('members_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('members_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="content_mod">Content:</label>
    <?php echo checkbox_tag('content_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('content_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('content_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="subscriptions_mod">Subscriptions:</label>
    <?php echo checkbox_tag('subscriptions_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('subscriptions_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('subscriptions_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="messages_mod">Messages:</label>
    <?php echo checkbox_tag('messages_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('messages_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('messages_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="feedback_mod">Feedback:</label>
    <?php echo checkbox_tag('feedback_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('feedback_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('feedback_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="flags_mod">Flags:</label>
    <?php echo checkbox_tag('flags_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('flags_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('flags_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="reports_mod">Reports:</label>
    <?php echo checkbox_tag('reports_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('reports_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('reports_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="users_mod">Admin Users:</label>
    <?php echo checkbox_tag('users_mod', 1, false, array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('users_mod_type', 'V', true, array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('users_mod_type', 'E', false, array('class' => 'radio')) ?><var>Edit</var><br />
  </fieldset>
  
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
    
    <label for="must_change_pwd">&nbsp;</label>
    <?php echo checkbox_tag('must_change_pwd', 1, false, 'class=checkbox') ?><var>User must reset password on next log in.</var><br /><br />
  </fieldset>
    
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'users/list', 'class=button') . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
