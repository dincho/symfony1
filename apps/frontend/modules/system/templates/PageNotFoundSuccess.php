<?php slot('header_title') ?>
    <?php echo __('Oops, Page Not Found') ?>
<?php end_slot(); ?>

<?php echo __('Sorry, we could not find the page you are looking for.'); ?><br /><br />
<?php echo __('If you\'re a member, please go to your <a href="%URL_FOR_DASHBOARD%" class="sec_link">dashboard.</a><br /><br />'); ?>
<?php echo __('If you\'re not a member, please <a href="%URL_FOR_JOIN_NOW%" class="sec_link">sign up for free now</a> or <a href="%URL_FOR_HOMEPAGE%" class="sec_link">go to homepage</a>');?>