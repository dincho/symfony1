<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('@edit_group?id=' . $group->getId(), 'class=form') ?>
  <?php echo input_hidden_tag("group_id", $group->getId(), 'class=hidden') ?>
  <div class="legend">Editing Group: <?php echo $group->getGroupName() ?></div>
  <fieldset class="form_fields">
    
    <label for="group_name">Name:</label>
    <?php echo object_input_tag($group, 'getGroupName', error_class('group_name')) ?><br />
    
    <label for="group_description">Description:</label>
    <?php echo object_input_tag($group, 'getGroupDescription', error_class('group_description')) ?><br />

    <label for="group_actions">Group Actions</label>
    <?php echo select_tag('group_actions',
                        options_for_select($dirs, $group_actions),
                        array("multiple" => true, "style" => "height: 200px; width: 200px")
                       )?><br />    
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', '@list_groups')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
