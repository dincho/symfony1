<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('settings/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($setting, 'getId', 'class=hidden') ?>
  <div class="legend">Editing: <?php echo $setting->getDescription() ?></div>
  <fieldset class="form_fields">
    <label for="value">Value:</label>
    <?php echo object_input_tag($setting, 'getValue') ?>
      
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'settings/list')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
