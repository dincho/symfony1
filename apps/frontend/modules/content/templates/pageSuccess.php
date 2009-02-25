<?php echo $sf_data->getRaw('page')->getContent() ?>
<?php slot('header_title') ?>
    <?php echo $page->getTitle() ?>
<?php end_slot(); ?>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>