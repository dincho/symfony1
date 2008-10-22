<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('@create_group', 'class=form') ?>
  <div class="legend">New Group</div>
  <fieldset class="form_fields">
    
    <label for="group_name">Name:</label>
    <?php echo input_tag('group_name', null, error_class('group_name')) ?><br />
    
    <label for="group_description">Description:</label>
    <?php echo input_tag('group_description', null, error_class('group_description')) ?><br />

    <label for="group_actions">Group Actions</label>
    <?php echo select_tag('group_actions',
                        options_for_select($dirs),
                        array("multiple" => true, "style" => "height: 200px; width: 200px")
                       )?><br />    
    
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', '@list_groups') . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
