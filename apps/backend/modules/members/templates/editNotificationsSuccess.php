<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail() . '&username=' . $member->getUsername(), 'class=float-right') ?>
<?php include_component('members', 'profilePager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Notifications</div>
  
<?php echo form_tag('members/editNotifications', array('class' => 'form')) ?>

  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editNotifications?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
    
  <fieldset class="form_fields">
    <?php echo radiobutton_tag('email_notifications', 0, ($member->getEmailNotifications() == 0), array('id' => 'email_notifications_0')) ?>
    <?php echo pr_label_for('email_notifications_0', 'Each time') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 1, ($member->getEmailNotifications() == 1), array('id' => 'email_notifications_1')) ?>
    <?php echo pr_label_for('email_notifications_1', 'Every 24 hours') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 3, ($member->getEmailNotifications() == 3), array('id' => 'email_notifications_3')) ?>
    <?php echo pr_label_for('email_notifications_3', 'Every 3 days') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 7, ($member->getEmailNotifications() == 7), array('id' => 'email_notifications_7')) ?>
    <?php echo pr_label_for('email_notifications_7', 'Every 7 days') ?><br />
    
    <?php echo radiobutton_tag('email_notifications', 'no', (is_null($member->getEmailNotifications())), array('id' => 'email_notifications_no')) ?>
    <?php echo pr_label_for('email_notifications_no', 'Do not send') ?><br />
  </fieldset> 
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/editNotifications?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

<?php include_partial('members/subMenu', array('member' => $member)); ?>
