<?php use_helper('Catalog'); ?>
<?php echo select_catalog2url(null, $url, $sf_request->getParameter('cat_id'), (isset($html_options)) ? $html_options : array()); ?>