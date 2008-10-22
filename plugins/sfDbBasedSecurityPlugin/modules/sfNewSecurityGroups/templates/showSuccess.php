<?php use_helper("Javascript") ?>

<h1>Show Group</h1>
<table>
  <tr>
    <th>Group Name</th>
    <td align="left">
        <?php echo $group->getGroupName() ?>
    </td>
  </tr>
  <tr>
    <th>Group Description</th>
    <td align="left">
        <?php echo $group->getGroupDescription() ?>
    </td>
  </tr>
  <tr>
    <th>Group Actions</th>
    <td align="left">
        <?php foreach ($group_actions as $action) : ?>
            <?php echo "$action<br>" ?>
        <?php endforeach; ?>
    </td>
  </tr>
</table>
<?php echo button_to("Edit", "@edit_group?id={$group->getId()}") ?>
<?php echo button_to("List Groups", "@list_groups") ?>
<?php echo button_to_function("Back", "history.go(-1)") ?>