<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('members/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <div class="legend">Member Information</div>
  <table class="details">
      <tr>
          <td class="form_fields" style="vertical-align: top">
            <?php include_partial('members/member_edit', array('member' => $member)); ?>
          </td>
          
          <td class="form_fields" style="padding-right: 0">
            <?php include_partial('members/member_notes', array('notes' => $notes)); ?>
          </td> 
      </tr>
  </table>
  
  <?php include_partial('flags/member_flagged', array('flags' => $flags)); ?>
  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'members/edit?cancel=1&id=' . $member->getId())  . submit_tag('Save', 'class=button name=submit_save') ?>
  </fieldset>
</form>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>