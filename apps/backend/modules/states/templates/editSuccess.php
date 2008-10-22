<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('states/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($state, 'getId', 'class=hidden') ?>
  <div class="legend">Editing State: <?php echo $state->getTitle() ?></div>
  <fieldset class="form_fields">
    
    <label for="country">Country:</label>
    <?php echo object_select_country_tag($state, 'getCountry', error_class('country')) ?><br />
    
    <label for="title">Title:</label>
    <?php echo object_input_tag($state, 'getTitle', error_class('title')) ?><br />

  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'states/list?confirm_msg=' . confirmMessageFilter::CANCEL)  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
