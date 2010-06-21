<?php slot('header_title') ?>
<?php echo __('Close or Upgrade your registration') ?>
<?php end_slot(); ?>

<?php $upgrade_url = 'subscription/index';
      $close_url = 'dashboard/deleteYourAccount'; ?>
<?php echo __('Welcome back. You can <a href="%URL_FOR_UPGRAGE_REGISTRATION%" class="sec_link">Upgarde your registration</a> or <a href="%URL_FOR_CLOSE_REGISTRATION%" class="sec_link">Close it</a>.', 
    array('%URL_FOR_UPGRAGE_REGISTRATION%'  => url_for($upgrade_url),
          '%URL_FOR_CLOSE_REGISTRATION%'    => url_for($close_url))) ?>