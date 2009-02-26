<?php echo $sf_data->getRaw('page')->getContent() ?>
<?php slot('header_title') ?>
    <?php echo $page->getTitle() ?>
<?php end_slot(); ?>
<?php
if ($sf_request->getParameter('slug') === 'affiliates') {
	slot('footer_menu');
		include_partial('content/footer_menu');
	end_slot(); 
} 
?>