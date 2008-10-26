<div id="secondary_container">
<?php echo form_tag('profile/signIn', array('id' => 'sign_in')) ?>
    <fieldset>
        <legend>Sign in to continue...</legend>
        <label for="email">Email</label> <input type="text" name="email" class="input_text_width" value="Diego_Bell@polishromance.com" /><br />
        <label for="password">Password</label> <input type="password" name="password" class="input_text_width" size="20" value="Diego_Bell" /><br />
        <span><?php echo link_to('Forgot your Password?', 'profile/forgotYourPassword', array('class' => 'sec_link_small')) ?></span>
    </fieldset>
    <input type="submit" class="sign_in" value="" /><br />
    <?php echo __('New to PolishRomance.com? %link_to_join_now%', array('%link_to_join_now%' => link_to(__('Join for free'), 'registration/joinNow', array('class' => 'sec_link')))) ?>
</form>
</div>