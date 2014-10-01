<?php slot('header_title') ?>
<?php echo __('Photo Verification Required') ?>
<?php end_slot(); ?>

<?php echo __('Welcome back. You have to <a href="%URL_FOR_PHOTO_VERIFICATION%" class="sec_link">verify your photo</a>.',
          array('%URL_FOR_PHOTO_VERIFICATION%' => url_for('@verify_photo'))) ?>
