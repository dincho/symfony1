<?php echo __('If you forget your password, you can enter your email address below and we will send you an email with a temporary password.'); ?>
<?php echo form_tag('profile/forgotYourPassword', 'id=forgot_password') ?>
    <label for="email"><?php echo __('Your email address'); ?></label>
    <?php echo input_tag('email', null, array('class' => 'input_text_width', 'size' => 25)) ?>
    <?php echo submit_tag('', array('class' => 'submit_class')) ?>
</form>
