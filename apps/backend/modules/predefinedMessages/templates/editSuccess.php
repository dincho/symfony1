<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('predefinedMessages/edit', 'class=form') ?>
    <?php echo input_hidden_tag('id', $message->getId()); ?>
  <div class="legend">Edit Predefined Message</div>
  <fieldset class="form_fields">
    <label for="sex">Sex:</label>
    <?php echo select_tag('sex', options_for_select(array('' => '--', 'M' => 'Male', 'F' => 'Female'), $message->getSex()), error_class('sex')) ?><br />

    <label for="looking_for">Looking for:</label>
    <?php echo select_tag('looking_for', options_for_select(array('' => '--', 'M' => 'Male', 'F' => 'Female'), $message->getLookingFor()), error_class('looking_for')) ?><br />
    
  </fieldset>
  
  <hr />
  
  <fieldset class="form_fields email_fields">
    <label for="subject">Subject:</label>
    <?php echo input_tag('subject', $message->getSubject(), error_class('subject')) ?><br />
              
    <label for="body">Body</label>
    <?php echo textarea_tag('message_body', $message->getBody(), array('cols' => 90, 'rows' => 10, 'class' => error_class('message_body', true), )) ?><br />
  </fieldset>        

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'predefinedMessages/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
