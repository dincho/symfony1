<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('catalogue/create', 'class=form') ?>
  <div class="legend">Creating New Catalogue</div>
  <fieldset class="form_fields">
    <label for="language">Language:</label>
    <?php echo select_language_tag('language') ?>
  </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'catalogue/list')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>

