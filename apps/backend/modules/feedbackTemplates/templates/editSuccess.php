<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('feedbackTemplates/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($template, 'getId', 'class=hidden') ?>
  <div class="legend">Editing Template: <?php echo $template->getname() ?></div>
  <fieldset class="form_fields">
    <label for="name">Name:</label>
    <?php echo object_input_tag($template, 'getName', error_class('name')) ?><br />

    <label for="mail_from">Send from Address:</label>
    <?php echo object_input_tag($template, 'getMailFrom', error_class('mail_from')) ?><br />
          
    <label for="reply_to">Reply to Address:</label>
    <?php echo object_input_tag($template, 'getReplyTo', error_class('reply_to')) ?><br />
          
    <label for="bcc">Bcc:</label>
    <?php echo object_input_tag($template, 'getBcc', error_class('bcc')) ?><br />
  </fieldset>
  <fieldset class="form_fields email_fields">
    <label for="subject">Subject:</label>
    <?php echo object_input_tag($template, 'getSubject', error_class('subject')) ?><br />
              
    <label for="body">Body</label>
    <?php echo object_textarea_tag($template, 'getBody', array('cols' => 90, 'rows' => 10)) ?><br />
    
    <label for="message_footer">Footer</label>
    <?php echo object_textarea_tag($template, 'getFooter', array('cols' => 90, 'rows' => 5)) ?><br />
      
    <label for="tags">Tags:</label>
    <?php echo object_textarea_tag($template, 'getTags',
            array(
                 'size' => '60x2',
                 'style'=>'width: 395px;float: left;height: 100px;'
            )
    ) ?>
    <div style="float:left;">
      <?php echo select_tag( 'defined_tags', options_for_select(FeedbackTemplatePeer::getTagsWithKeys(), null),
          array(
               'size' => 5,
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
