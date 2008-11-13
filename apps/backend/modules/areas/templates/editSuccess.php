<?php use_helper('Object', 'dtForm', 'I18N', 'Javascript') ?>

<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('areas/edit', 'class=form') ?>
  <div class="legend">Editing Areas of Country: <?php echo format_country($country) ?></div>
  <fieldset class="form_fields" id="states_fieldset">
    
    <label for="country">Country:</label>
    <?php echo select_country_tag('country', $country, array('onchange' => "document.location.href = '". url_for('areas/edit') ."/country/' + this.value;")) ?><br />
    
    <label for="title">Areas:</label><br />
    <?php foreach ($states as $state): ?>
        <label>&nbsp;</label>
        <?php echo object_input_tag($state, 'getTitle', array('class' => error_class('title', true), 'control_name' => 'states[' . $state->getId() . ']') ) ?><br />
    <?php endforeach; ?>
    
    <label>&nbsp;</label>
    <?php echo link_to_function('+Add', 'add_form_field(this.parentNode) ', array('style' => 'float: left')) ?><br />
  </fieldset> 
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'areas/edit?confirm_msg=' . confirmMessageFilter::CANCEL)  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
