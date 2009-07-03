<?php if (!cache('page_' . $page->getSlug())): ?>
    <?php echo $sf_data->getRaw('page')->getContent() ?>
  <?php cache_save() ?>
<?php endif; ?>

<?php slot('header_title') ?>
    <?php echo $page->getTitle(ESC_RAW) ?>
<?php end_slot(); ?>

<?php if ($page->getHasMiniMenu()): ?> 
	<?php slot('footer_menu'); ?>
		<?php include_partial('content/footer_menu', array('auth' => $sf_user->isAuthenticated())); ?>
	<?php end_slot(); ?> 
<?php endif; ?>