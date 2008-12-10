<?php use_helper('Object', 'dtForm', 'Javascript') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('flags/profile', 'class=form') ?>
  <?php echo object_input_hidden_tag($member, 'getId', 'class=hidden') ?>
  <div class="legend">Flaggind Member</div>
  <table class="details">
      <tr>
          <td class="form_fields" style="vertical-align: top">
            <?php include_partial('members/member_details', array('member' => $member)); ?>
          </td>
          
          <td class="form_fields" style="padding-right: 0">
            <?php include_partial('members/member_notes', array('notes' => $notes)); ?>
          </td> 
      </tr>
  </table>
  
  <?php include_partial('flags/member_flagger', array('flags' => $flags)); ?>
  
  <fieldset class="actions">
    <?php echo button_to_function('Close', 'window.history.go(-1)') . button_to('Reset Flags', '#')  . button_to('Suspend', '#') ?>
  </fieldset>
</form>

