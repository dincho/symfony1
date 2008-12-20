<?php echo $sf_data->getRaw('page')->getContent() ?>
<?php slot('header_title') ?>
    <?php echo $page->getTitle() ?>
<?php end_slot(); ?>