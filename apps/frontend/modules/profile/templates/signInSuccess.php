<div id="secondary_container">
<?php echo form_tag('profile/signIn', array('id' => 'sign_in')) ?>
    <fieldset>
        <legend><?php echo __('Sign in to continue...') ?></legend>
        <label for="email"><?php echo __('Email') ?></label> <input type="text" name="email" class="input_text_width" value="<?php echo $test_member->getEmail() ?>" /><br />
        <label for="password"><?php echo __('Password') ?></label> <input type="password" name="password" class="input_text_width" size="20" value="<?php echo $test_member->getUsername() ?>" /><br />
        <span><?php echo link_to('Forgot your Password?', 'profile/forgotYourPassword', array('class' => 'sec_link_small')) ?></span>
    </fieldset>
    <input type="submit" class="sign_in" value="" /><br />
    <?php echo __('New to PolishRomance.com? %link_to_join_now%', array('%link_to_join_now%' => link_to(__('Join for free'), 'registration/joinNow', array('class' => 'sec_link')))) ?>
</form>
</div>