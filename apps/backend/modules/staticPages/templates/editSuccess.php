<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('staticPages/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($page, 'getId', 'class=hidden') ?>
  <div class="legend">Edit <?php echo $page->getSlug() ?>.html</div>
      <fieldset class="form_fields float-left">
        <label for="link_name">Link Name:</label>
        <?php echo object_input_tag($page, 'getLinkName', error_class('link_name')) ?><br />
        
        <label for="culture">Language:</label>
        <?php echo object_select_language_tag($page, 'getCulture', array('onchange' => 'document.location.href=\'' . url_for('staticPages/edit?id=' . $page->getId()). '/culture/\' + this.value ')); ?><br />
    
      </fieldset>
      <fieldset class="form_fields float-left">
        
        <label for="title">Title:</label>
        <?php echo object_input_tag($page, 'getTitle', error_class('title')) ?><br /> 
          
        <label for="keywords">Keywords:</label>
        <?php echo object_input_tag($page, 'getKeywords', error_class('keywords')) ?><br />
        
        <label for="description">Description:</label>
        <?php echo object_input_tag($page, 'getDescription', error_class('description')) ?><br />
       
      </fieldset>
  
  <fieldset class="form_fields email_fields">
    <label for="html_content">HTML Content:</label>
    <?php echo textarea_tag('html_content', $page->getContent(), 'id=html_content ' . error_class('html_content')) ?>
  </fieldset>        

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'staticPages/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
