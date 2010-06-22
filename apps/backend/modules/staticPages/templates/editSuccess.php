<?php use_helper('Object', 'dtForm', 'I18N') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('staticPages/edit', 'class=form') ?>
  <?php echo object_input_hidden_tag($page, 'getId', array('class' => 'hidden')); ?>
  <?php echo object_input_hidden_tag($page, 'getCatId', array('class' => 'hidden')); ?>
  
  <div class="legend">Edit <?php echo $page->getSlug() ?>.html</div>
      <fieldset class="form_fields float-left">
        <label for="link_name">Link Name:</label>
        <span style="float: left"><?php echo object_input_tag($page, 'getLinkName', error_class('link_name')) ?></span><br />
        
        <label for="catalog">Catalog:</label>
        <var><?php echo $page->getCatalogue() ?></var>
    
      </fieldset>
      <fieldset class="form_fields float-left">
        
        <label for="title">Title:</label>
        <?php echo object_input_tag($page, 'getTitle', error_class('title')) ?><br /> 
          
        <label for="keywords">Keywords:</label>
        <?php echo object_input_tag($page, 'getKeywords', error_class('keywords')) ?><br />
        
        <label for="description">Description:</label>
        <?php echo object_textarea_tag($page, 'getDescription', 'cols=26 rows=2 ' . error_class('description')) ?><br />
       
      </fieldset>
  
  
      <fieldset class="form_fields email_fields" style="margin-top: 150px;">
        <?php if( $page->getSlug() == 'best_videos'): ?>
            <label>&nbsp;</label>
            <var><?php echo link_to('Regenerate Best Videos Content', 'staticPages/edit?regenerate_best_videos=1&culture=' . $page->getCulture() . '&id=' . $page->getId()) ?></var><br />
        <?php endif; ?>
        
        <?php if( $page->hasContent() ): ?>
            <label for="html_content">HTML Content:</label>
            <?php $content = ($sf_request->getParameter('regenerate_best_videos') && $page->getSlug() == 'best_videos') ? get_component('staticPages', 'bestVideos', array('cat_id' => $page->getCatId())) : $page->getContent() ?>
            <?php echo textarea_tag('html_content', $content, 'id=html_content rows=20 cols=38' . error_class('html_content')) ?>
        <?php endif; ?>
      </fieldset>

  
  <fieldset class="actions">
    <?php echo button_to('Cancel', 'staticPages/list?cancel=1')  . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'staticPages/edit?id=' . $page->getId())) ?>

