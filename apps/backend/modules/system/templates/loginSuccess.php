<?php echo form_tag('system/login', 'class=form style=width: 550px; margin: auto; display: block;') ?>
  <div class="legend">Sign In</div>
  <fieldset class="form_fields" style="margin: 15px 0">
    <label for="username">Username:</label>
    <?php echo input_tag('username') ?><br />
    
    <label for="password">Password:</label>
    <?php echo input_password_tag('password') ?><br />
  </fieldset>
  <fieldset class="actions">
    <?php echo submit_tag('Login') ?>
  </fieldset>
</form>