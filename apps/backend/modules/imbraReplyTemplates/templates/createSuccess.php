<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('imbraReplyTemplates/create', 'class=form') ?>
  <div class="legend">New Template</div>
  <fieldset class="form_fields">
    <label for="title">Title:</label>
    <?php echo input_tag('title', null, error_class('title')) ?><br />

    <label for="mail_from">Send from Address:</label>
    <?php echo input_tag('mail_from', null, error_class('mail_from')) ?><br />
          
    <label for="reply_to">Reply to Address:</label>
    <?php echo input_tag('reply_to', null, error_class('reply_to')) ?><br />
          
    <label for="bcc">Bcc:</label>
    <?php echo input_tag('bcc', null, error_class('bcc')) ?><br />
  </fieldset>
  <fieldset class="form_fields email_fields">
    <label for="subject">Subject:</label>
    <?php echo input_tag('subject', null, error_class('subject')) ?><br />
              
    <label for="body">Body:</label>
    <?php echo textarea_tag('body', null, error_class('body')) ?><br />
  </fieldset>        

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'imbraReplyTemplates/list')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
