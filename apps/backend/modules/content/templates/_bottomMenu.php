<?php use_helper('Catalog'); ?>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
    <?php echo select_catalog2url(null, $url, $sf_request->getParameter('cat_id'), (isset($html_options)) ? $html_options : array()); ?>  
</div>