<?php echo form_tag('groups/delete') ?>
  <table class="zebra">
    <thead>
      <tr class="top_actions">
        <td colspan="3"><?php echo button_to('Add Group', '@create_group') ?></td>
      </tr>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($groups as $group): ?>
      <tr rel="<?php echo url_for('@edit_group?id=' . $group->getId()) ?>" >
        <td class="marking"><?php echo checkbox_tag('marked[]', $group->getId(), null) ?></td>
        <td><?php echo $group->getGroupName(); ?></td>
        <td><?php echo $group->getGroupDescription() ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php echo submit_tag('Delete', 'confirm=Are you sure you want to delete selected groups?') ?>
</form>
