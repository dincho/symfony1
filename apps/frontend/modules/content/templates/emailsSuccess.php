<?php slot('header_title') ?>
    <?php echo $email->getSubject(); ?>
<?php end_slot(); ?>

<?php echo $email->getBody(ESC_RAW) ?>