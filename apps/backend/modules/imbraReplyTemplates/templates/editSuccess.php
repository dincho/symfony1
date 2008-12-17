<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('imbraReplyTemplates/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($imbra_reply_template, 'getId', 'class=hidden') ?>
  <div class="legend">Editing Template: <?php echo $imbra_reply_template->getTitle() ?></div>
  <fieldset class="form_fields">
    <label for="title">Title:</label>
    <?php echo object_input_tag($imbra_reply_template, 'getTitle', error_class('title')) ?><br />

    <label for="mail_from">Send from Address:</label>
    <?php echo object_input_tag($imbra_reply_template, 'getMailFrom', error_class('mail_from')) ?><br />
          
    <label for="reply_to">Reply to Address:</label>
    <?php echo object_input_tag($imbra_reply_template, 'getReplyTo', error_class('reply_to')) ?><br />
          
    <label for="bcc">Bcc:</label>
    <?php echo object_input_tag($imbra_reply_template, 'getBcc', error_class('bcc')) ?><br />
  </fieldset>
  <fieldset class="form_fields email_fields">
    <label for="subject">Subject:</label>
    <?php echo object_input_tag($imbra_reply_template, 'getSubject', error_class('subject')) ?><br />
              
    <label for="body">Body:</label>
    <?php echo object_textarea_tag($imbra_reply_template, 'getBody', array('cols' => 90, 'rows' => 10, 'class' => error_class('body', true))) ?><br />
  </fieldset>        

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'imbraReplyTemplates/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
