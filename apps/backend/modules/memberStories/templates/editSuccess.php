<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('memberStories/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($story, 'getId', 'class=hidden') ?>
  <div class="legend">Edit <?php echo $story->getSlug() ?>.html</div>
      <fieldset class="form_fields float-left">
        <label for="link_name">Link Name:</label>
        <?php echo object_input_tag($story, 'getLinkName', error_class('link_name')) ?><br />
        
        <label for="slug">URL Name:</label>
        <?php echo object_input_tag($story, 'getSlug', null, error_class('slug')) ?>.html<br />
                
        <label for="culture">Language:</label>
        <?php echo object_select_language_tag($story, 'getCulture', array('onchange' => 'document.location.href=\'' . url_for('memberStories/edit?id=' . $story->getId()). '/culture/\' + this.value ')); ?><br />
    
      </fieldset>
      <fieldset class="form_fields float-left">
        
        <label for="title">Title:</label>
        <?php echo object_input_tag($story, 'getTitle', error_class('title')) ?><br /> 
          
        <label for="keywords">Keywords:</label>
        <?php echo object_input_tag($story, 'getKeywords', error_class('keywords')) ?><br />
        
        <label for="description">Description:</label>
        <?php echo object_input_tag($story, 'getDescription', error_class('description')) ?><br />
       
      </fieldset>
  
  <fieldset class="form_fields email_fields">
    <label for="html_content">HTML Content:</label>
    <?php echo textarea_tag('html_content', $story->getContent(), 'id=html_content ' . error_class('html_content')) ?>
  </fieldset>        

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'memberStories/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
