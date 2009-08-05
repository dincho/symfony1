<?php slot('header_title') ?>
    <?php echo $email->getSubject(); ?>
<?php end_slot(); ?>

<?php echo nl2br($email->getBody(ESC_RAW)); ?>