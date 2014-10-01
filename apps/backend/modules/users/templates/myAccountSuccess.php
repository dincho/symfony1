<?php use_helper('Object', 'dtForm') ?>
<?php include_component('system', 'formErrors') ?>

<?php echo form_tag('users/myAccount', 'class=form') ?>
  <div class="legend">My Account</div>
  <fieldset class="form_fields">
    <label for="first_name">First Name:</label>
    <?php echo object_input_tag($user, 'getFirstName', error_class('first_name')) ?><br />

    <label for="last_name">Last Name:</label>
    <?php echo object_input_tag($user, 'getLastName', error_class('last_name')) ?><br />

    <label for="email">Email:</label>
    <?php echo object_input_tag($user, 'getEmail', error_class('email')) ?><br />

    <label for="phone">Phone:</label>
    <?php echo object_input_tag($user, 'getPhone', error_class('phone')) ?><br />

    <label for="password">Password:</label>
    <?php echo input_password_tag('password', null, error_class('password')) ?><br />

    <label for="password2">Re-enter Password:</label>
    <?php echo input_password_tag('password2', null, error_class('password2')) ?><br />
  </fieldset>

  <fieldset class="actions">
    <?php echo button_to('Cancel', 'dashboard/index', 'class=button') . submit_tag('Save', 'class=button') ?>
  </fieldset>
</form>
