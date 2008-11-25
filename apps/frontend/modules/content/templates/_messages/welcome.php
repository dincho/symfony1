<?php slot('header_title') ?>
    <?php echo __('Welcome') ?>
<?php end_slot(); ?>
<?php echo __('Congratulations! You’ve just activated your account. <a href="{REGISTRATION_URL}" class="sec_link">Please finish the sign up now.</a>', array('{REGISTRATION_URL}' => url_for('registration/index'))) ?>