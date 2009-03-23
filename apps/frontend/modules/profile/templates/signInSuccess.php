<?php slot('header_title') ?>
    <?php echo __('Member Sign In') ?>
<?php end_slot(); ?>

<div id="secondary_container">
<?php echo form_tag('profile/signIn', array('id' => 'sign_in')) ?>
    <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
    <fieldset>
        <div style="background-color: #000000; padding: 1px; padding-left: 8px; text-align: left;"><?php echo __('Sign in to continue...') ?></div>
        <label for="email"><?php echo __('Email') ?></label> <input type="text" name="email" class="input_text_width" style="width: 148px;" /><br />
        <label for="password"><?php echo __('Password') ?></label> <input type="password" name="password" class="input_text_width" size="20" style="width: 148px;" /><br />        
        <span><?php echo link_to('Forgot your Password?', 'profile/forgotYourPassword', array('class' => 'sec_link_small')) ?></span>
    </fieldset>
    <br/>
    <?php echo submit_tag('Sign In', array('class' => 'button sign_in')) ?><br />
    <?php echo __('New to PolishRomance.com? <a href="%URL_FOR_JOIN_NOW%" class="sec_link">Join for free</a>') ?>
</form>
</div>