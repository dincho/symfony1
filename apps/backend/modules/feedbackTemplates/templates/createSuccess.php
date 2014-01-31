<?php use_helper('dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('feedbackTemplates/create', 'class=form') ?>
  <div class="legend">New Message Template to Users</div>
  <fieldset class="form_fields">
    <label for="name">Name:</label>
    <?php echo input_tag('name', null, error_class('name')) ?><br />

    <label for="mail_from">Send from Address:</label>
    <?php echo input_tag('mail_from', null, error_class('mail_from')) ?><br />
          
    <label for="reply_to">Reply to Address:</label>
    <?php echo input_tag('reply_to', null, error_class('reply_to')) ?><br />
          
    <label for="bcc">Bcc:</label>
    <?php echo input_tag('bcc', null, error_class('bcc')) ?><br />
  </fieldset>
  
  <hr />
  
  <fieldset class="form_fields email_fields">
    <label for="subject">Subject:</label>
    <?php echo input_tag('subject', null, error_class('subject')) ?><br />
              
    <label for="body">Body</label>
    <?php echo textarea_tag('message_body', null, array('cols' => 90, 'rows' => 10)) ?><br />
    
    <label for="message_footer">Footer</label>
    <?php echo textarea_tag('message_footer', null, array('cols' => 90, 'rows' => 5)) ?><br />

      <label for="tags">Tags:</label>
      <?php echo textarea_tag('tags', '',
          array(
               'size' => '60x2',
               'style'=>'width: 395px;float: left;height: 100px;'
          )
      ) ?>
      <div style="float:left;">
          <?php echo select_tag( 'defined_tags', options_for_select(FeedbackTemplatePeer::getTagsWithKeys(), null),
              array(
                   'multiple' => true,
                   'style' => 'width:250px; height:106px;',
                   'onclick' => 'add_tags(this.value, "tags")'
              )
          )?>
      </div>
  </fieldset>        

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'feedbackTemplates/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
