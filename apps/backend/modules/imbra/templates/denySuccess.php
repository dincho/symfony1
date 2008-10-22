<?php use_helper('Object', 'Javascript') ?>

<?php echo form_tag('imbra/deny', 'class=form') ?>
<?php echo object_input_hidden_tag($imbra, 'getId', 'class=hidden'); ?>
<?php echo input_hidden_tag('member_id', $member->getId(), 'class=hidden') ?>

<div class="legend">Deny</div>
<fieldset class="form_fields">
  <table class="details">
    <tbody>
      <tr>
        <th>Username</th>
        <td><?php echo $member->getUsername(); ?></td>
        <th>Send from Address</th>
        <td><?php echo input_tag('mail_from', $template->getMailFrom()); ?></td>
      </tr>
      <tr>
        <th>First Name</th>
        <td><?php echo $member->getFirstName(); ?></td>
        <th>Reply to Address</th>
        <td><?php echo input_tag('reply_to', $template->getReplyTo()); ?></td>
      </tr>
      <tr>
        <th>Last Name</th>
        <td><?php echo $member->getLastName(); ?></td>
        <th>Bcc</th>
        <td><?php echo input_tag('bcc', $template->getBcc()); ?></td>
      </tr>
      <tr>
        <th>Profile ID</th>
        <td><?php echo $member->getId(); ?></td>
        <th></th>
        <td></td>
      </tr>
      <tr>
        <th>Template</th>
        <td><?php echo object_select_tag($template->getId(), 'template_id', array (
			      'related_class' => 'ImbraReplyTemplate',
			      'peer_method' => 'doSelect',
			    ))?>
        </td>
        <th></th>
        <td></td>
      </tr>
    <tbody>
  </table>
</fieldset>

<hr />

<fieldset class="form_fields email_fields">
  <label for="subject">Subject</label>
  <?php echo input_tag('subject', $template->getSubject()) ?><br />
  
  <label for="body">Body</label>
  <?php echo textarea_tag('body', $template->getBody()) ?><br />
  
  <label for="save_as_new_template">Save as new template</label>
  <?php echo input_tag('save_as_new_template', null, 'id=save_as_new_template') ?><br />
</fieldset>

<fieldset class="actions">
  <?php echo button_to('Cancel', 'imbra/edit?member_id=' . $member->getId() . '&id=' . $imbra->getId()) ?>
  <?php echo submit_tag('Send') ?>
</fieldset>

</form>
