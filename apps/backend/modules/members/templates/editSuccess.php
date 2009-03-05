<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<br /><br />

<?php echo form_tag('members/edit', 'class=form2') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <div class="legend">Member Information</div>
  <table class="details">
      <tr>
          <td class="form_fields" style="vertical-align: top; padding-right: 0">
            <?php include_partial('members/member_edit', array('member' => $member)); ?>
          </td>
          <td style="vertical-align: top; padding: 5px;"><?php echo link_to('view<br />profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
          <td class="form_fields" style="padding-right: 0">
            <?php include_partial('members/member_notes', array('notes' => $notes, 'member' => $member)); ?>
          </td> 
      </tr>
  </table>

  <?php include_partial('flags/member_flagged', array('flags' => $flags)); ?>
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/edit?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button name=submit_save') ?>
  </fieldset>
</form>


<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>