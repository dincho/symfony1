<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>

<br /><br />

<div class="legend">Member Information</div>

<?php echo form_tag('members/edit', 'class=form') ?>
  
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  
  <?php include_partial('members/subMenu', array('member_id' => $member->getId(), 'class' => 'top')); ?>
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/edit?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button name=submit_save') ?>
  </fieldset>
  
  <table class="details">
      <tr>
          <td class="form_fields" style="vertical-align: top; padding-right: 0">
            <?php include_partial('members/member_edit', array('member' => $member)); ?>
          </td>
          <td style="vertical-align: top; padding: 5px;"><?php echo link_to('view<br />profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
          <td class="form_fields" style="padding-right: 0">
            <?php include_partial('members/member_notes', array('notes' => $notes, 'member' => $member)); ?>
          </td>
          <td class="form_fields" style="padding-right: 0; padding-left: 20px; vertical-align: top;">
            <?php include_partial('members/activity_stats', array('member' => $member)); ?>
            <?php include_partial('members/photos', array('member' => $member)); ?>
            <hr />
            <?php $unread =  $member->getUnreadMessagesCount() == 0? $member->getUnreadMessagesCount() : '<strong>' . $member->getUnreadMessagesCount() . '</strong>' ?>
            <?php echo link_to(__('Feedback ( %UNREAD% / %ALL% )', 
                              array('%UNREAD%' => $unread, '%ALL%' => $member->getCounter('SentMessages') + $member->getCounter('ReceivedMessages') )),
                            'messages/member?id=' . $member->getId())  ?>
          </td>
      </tr>
  </table>

  <?php include_partial('flags/member_flagged', array('flags' => $flags)); ?>
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/edit?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button name=submit_save') ?>
  </fieldset>
</form>

<?php include_partial('members/subMenu', array('member_id' => $member->getId())); ?>