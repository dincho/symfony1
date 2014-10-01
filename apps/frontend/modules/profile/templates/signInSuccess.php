<?php slot('header_title') ?>
    <?php echo __('Member Sign In') ?>
<?php end_slot(); ?>

<?php echo form_tag('profile/signIn', array('id' => 'sign_in')) ?>
    <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
    <fieldset>
        <div style="background-color: #000000; padding: 1px; padding-left: 8px; text-align: left;"><?php echo __('Sign in to continue...') ?></div>
        <label for="email"><?php echo __('Email') ?></label>
        <?php echo input_tag('email', null, array('class' => 'input_text_width')); ?><br />

        <label for="password"><?php echo __('Password') ?></label>
        <?php echo input_password_tag('password', null, array('class' => 'input_text_width')); ?><br />

        <span><?php echo link_to(__('Forgot your Password?'), 'profile/forgotYourPassword', array('class' => 'sec_link_small')) ?></span>
    </fieldset><br class="clear" />

    <?php echo submit_tag(__('Sign In'), array('class' => 'button sign_in')) ?><br /><br />
    <?php echo __('New to PolishRomance.com? <a href="%URL_FOR_JOIN_NOW%" class="sec_link">Join for free</a>') ?>
</form>
