<?php use_helper('xSortableTitle') ?>

<?php echo form_tag('users/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="7"><?php echo button_to ('Add User', 'users/create') ?></td>
      </tr>
      <tr>
        <th></th>
        <th><?php echo sortable_title('Username', 'User::username', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Last name', 'User::first_name', $sort_namespace) ?></th>
        <th><?php echo sortable_title('First name', 'User::last_name', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Email', 'User::email', $sort_namespace) ?></th>
        <th><?php echo sortable_title('Status', 'User::is_enabled', $sort_namespace) ?></th>
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
        <td><?php echo $user->getStatus() ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected users?') ?>
</form>

