<?php use_helper('Object', 'dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('staticPages/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($page, 'getId', 'class=hidden') ?>
  <?php echo object_input_hidden_tag($page, 'getCulture', 'class=hidden') ?>
  <div class="legend">Edit <?php echo $page->getSlug() ?>.html</div>
      <fieldset class="form_fields float-left">
        <label for="link_name">Link Name:</label>
        <?php echo object_input_tag($page, 'getLinkName', error_class('link_name')) ?><br />
        
        <label for="culture">Language:</label>
        <var><?php echo format_language($page->getCulture()) ?></var>
    
      </fieldset>
      <fieldset class="form_fields float-left">
        
        <label for="title">Title:</label>
        <?php echo object_input_tag($page, 'getTitle', error_class('title')) ?><br /> 
          
        <label for="keywords">Keywords:</label>
        <?php echo object_input_tag($page, 'getKeywords', error_class('keywords')) ?><br />
        
        <label for="description">Description:</label>
        <?php echo object_textarea_tag($page, 'getDescription', 'cols=26 rows=2 ' . error_class('description')) ?><br />
       
      </fieldset>
  
  <fieldset class="form_fields email_fields">
    <label for="html_content">HTML Content:</label>
    <?php echo textarea_tag('html_content', $page->getContent(), 'id=html_content rows=20 cols=38' . error_class('html_content')) ?>
  </fieldset>        

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'staticPages/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($page->getCulture() == 'en', 'English', 'staticPages/edit?culture=en&id=' . $page->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to_unless($page->getCulture() == 'pl', 'Polish', 'staticPages/edit?culture=pl&id=' . $page->getId()) ?>&nbsp;</li>
  </ul>
</div>