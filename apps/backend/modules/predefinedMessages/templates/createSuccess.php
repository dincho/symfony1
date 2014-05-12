<?php use_helper('dtForm', 'Object') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('predefinedMessages/create', 'class=form') ?>
  <div class="legend">New Predefined Message</div>
  <fieldset class="form_fields">
    <label>Catalog:</label>
    <?php echo object_select_tag(null, 'getObjectId', array (
                                'related_class' => 'Catalogue',
                                'peer_method' => 'doSelect',
                                'control_name' => 'catalog_id',
                                'include_blank' => false,
                                )); ?><br />

    <label for="sex">Sex:</label>
    <?php echo select_tag('sex', options_for_select(array('' => '--', 'M' => 'Male', 'F' => 'Female')), error_class('sex')) ?><br />

    <label for="looking_for">Looking for:</label>
    <?php echo select_tag('looking_for', options_for_select(array('' => '--', 'M' => 'Male', 'F' => 'Female')), error_class('looking_for')) ?><br />

  </fieldset>

  <hr />

  <fieldset class="form_fields email_fields">
    <label for="subject">Subject:</label>
    <?php echo input_tag('subject', null, error_class('subject')) ?><br />

    <label for="body">Body</label>
    <?php echo textarea_tag('message_body', null, array('cols' => 90, 'rows' => 10, 'class' => error_class('message_body', true), )) ?><br />
  </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'predefinedMessages/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
