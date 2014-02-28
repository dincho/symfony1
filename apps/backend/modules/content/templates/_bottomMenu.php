<?php use_helper('Catalog'); ?>
<div id="bottom_menu" class="bottom_menu_content">
  <span class="bottom_menu_title">Edit:</span>
    <?php echo select_catalog2url(null, $url, $sf_request->getParameter('cat_id'), (isset($html_options)) ? $html_options : array('style' => 'float: left')); ?>
  <?php if( isset($showMultiMenu) ): ?>
      <span class="bottom_menu_title multi_save">Also Save For:</span>
        <?php echo select_tag('affected_catalogs', options4select_catalog($sf_request->getParameter('cat_id')),
                        array('multiple' => true, 'style' => 'width: 300px')
                        ); ?>
    <?php endif; ?>
</div>