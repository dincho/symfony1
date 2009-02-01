<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('users/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($user, 'getId', 'class=hidden') ?>
  <div class="legend">Editing User: <?php echo $user->getUsername() ?></div>
  <fieldset class="form_fields float-right" style="margin-right: 200px">
    <label for="dashboard_mod">Dashboard:</label>
    <?php echo object_checkbox_tag($user, 'getDashboardMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('dashboard_mod_type', 'V', $user->getDashboardModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('dashboard_mod_type', 'E', $user->getDashboardModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="members_mod">Members:</label>
    <?php echo object_checkbox_tag($user, 'getMembersMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('members_mod_type', 'V', $user->getMembersModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('members_mod_type', 'E', $user->getMembersModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="content_mod">Content:</label>
    <?php echo object_checkbox_tag($user, 'getContentMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('content_mod_type', 'V', $user->getContentModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('content_mod_type', 'E', $user->getContentModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="subscriptions_mod">Subscriptions:</label>
    <?php echo object_checkbox_tag($user, 'getSubscriptionsMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('subscriptions_mod_type', 'V', $user->getSubscriptionsModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('subscriptions_mod_type', 'E', $user->getSubscriptionsModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="messages_mod">Messages:</label>
    <?php echo object_checkbox_tag($user, 'getMessagesMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('messages_mod_type', 'V', $user->getMessagesModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('messages_mod_type', 'E', $user->getMessagesModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="feedback_mod">Feedback:</label>
    <?php echo object_checkbox_tag($user, 'getFeedbackMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('feedback_mod_type', 'V', $user->getFlagsModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('feedback_mod_type', 'E', $user->getFeedbackModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
        
    <label for="flags_mod">Flags:</label>
    <?php echo object_checkbox_tag($user, 'getFlagsMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('flags_mod_type', 'V', $user->getFlagsModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('flags_mod_type', 'E', $user->getFlagsModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="imbra_mod">IMBRA:</label>
    <?php echo object_checkbox_tag($user, 'getImbraMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('imbra_mod_type', 'V', $user->getImbraModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('imbra_mod_type', 'E', $user->getImbraModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="reports_mod">Reports:</label>
    <?php echo object_checkbox_tag($user, 'getReportsMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('reports_mod_type', 'V', $user->getReportsModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('reports_mod_type', 'E', $user->getReportsModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
    
    <label for="users_mod">Admin Users:</label>
    <?php echo object_checkbox_tag($user, 'getUsersMod', array('class' => 'checkbox')) ?><var>&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('users_mod_type', 'V', $user->getUsersModType() == 'V', array('class' => 'radio')) ?><var>View&nbsp;&nbsp;&nbsp;</var>
    <?php echo radiobutton_tag('users_mod_type', 'E', $user->getUsersModType() == 'E', array('class' => 'radio')) ?><var>Edit</var><br />
  </fieldset>
  
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
    <?php echo input_password_tag('password', null, error_class('password')) ?><br />
    
    <label for="password2">Re-enter Password:</label>
    <?php echo input_password_tag('password2', null, error_class('password2')) ?><br />
        
    <label for="is_enabled">Status:</label>
    <?php echo select_tag('is_enabled', options_for_select(array(1 => 'Enabled', 0 => 'Disabled'), (int) $user->getIsEnabled())) ?><br />
    
    <label for="must_change_pwd">&nbsp;</label>
    <?php echo object_checkbox_tag($user, 'getMustChangePwd', 'class=checkbox') ?><var>User must reset password on next log in.</var><br /><br />
  </fieldset>
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'users/list', 'class=button') . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
