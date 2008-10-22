<?php echo form_tag('users/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="7"><?php echo button_to ('Add User', 'users/create') ?></td>
      </tr>
      <tr>
        <th></th>
        <th>Username</th>
        <th>Last name</th>
        <th>First name</th>
        <th>Email</th>
        <th>Groups</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
      <tr rel="<?php echo url_for('users/edit?id=' . $user->getId()) ?>" >
        <td class="marked"><?php echo checkbox_tag('marked[]', $user->getId(), null) ?></td>
        <td><?php echo $user->getUsername(); ?></td>
        <td><?php echo $user->getLastName() ?></td>
        <td><?php echo $user->getFirstName() ?></td>
        <td><?php echo $user->getEmail() ?></td>
        <td><?php $groups = sfNewSecurityQueries::listUserGroups($user->getId()); if( $groups ) echo implode(', ', $groups); ?></td>
        <td><?php echo $user->getStatus() ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected users?') ?>
</form>

