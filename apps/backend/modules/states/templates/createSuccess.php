<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('states/create', 'class=form') ?>
  <div class="legend">Add new state</div>
  <fieldset class="form_fields">
    
    <label for="country">Country:</label>
    <?php echo select_country_tag('country', error_class('country')) ?><br />
    
    <label for="title">Title:</label>
    <?php echo input_tag('title', error_class('title')) ?><br />

  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'states/list?confirm_msg=' . confirmMessageFilter::CANCEL)  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
