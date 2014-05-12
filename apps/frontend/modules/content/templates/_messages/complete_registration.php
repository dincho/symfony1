<?php slot('header_title') ?>
<?php echo __('Complete Registration') ?>
<?php end_slot(); ?>

<?php $url = $sf_user->getProfile()->getContinueRegistrationUrl(); ?>
<?php echo __('Welcome back. You may finish your registration <a href="%URL_FOR_CONTINUE_REGISTRATION%" class="sec_link">here</a>.', array('%URL_FOR_CONTINUE_REGISTRATION%' => url_for($url))) ?>
<div class="registration_continue">
    <?php echo link_to(__('Complete Registration'), $url, array('class' => 'button')) ?>
</div>
