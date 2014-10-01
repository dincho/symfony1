<?php echo form_tag('system/login', 'class=form2 style=width: 550px; margin: auto; display: block;') ?>
  <div class="legend">Sign In</div>
  <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
  <fieldset class="form_fields" style="margin: 15px 0">
    <div style="width: 280px; height: 60px; margin-left: 120px;">
    <label for="username">Username:</label>
    <?php echo input_tag('username') ?><br />
    <br />
    <label for="password">Password:</label>
    <?php echo input_password_tag('password') ?><br />
    </div>
  </fieldset>
  <fieldset class="actions">
    <?php echo submit_tag('Login') ?>
  </fieldset>
</form>
