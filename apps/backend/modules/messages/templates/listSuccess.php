<?php echo use_helper('Javascript', 'Number') ?>

<div class="filter_right">Total: <?php echo format_number($pager->getNbResults()) ?></div>
<?php include_partial('members/search_filter', array('filters' => $filters)); ?>


<table class="zebra">
  <thead>
    <tr>
      <th>Username</th>
      <th>ID</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Sex</th>
      <th>Email</th>
      <th>Last Activity</th>
      <th>Sent To</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $message): ?>
  <?php $member = $message->getMemberRelatedByFromMemberId(); //shortcut ?>
  <tr class="remote_function" rel="<?php echo remote_function(array('url' => 'ajax/getMessageById?details=1&id=' . $message->getId(), 'update' => 'preview')); ?>" onmouseover="preview_click('<?php echo $message->getId();?>')" onmouseout2="preview_clear();">
    <td><?php echo $member->getUsername() ?></td>
    <td><?php echo $member->getId() ?></td>
    <td><?php echo $member->getLastName() ?></td>
    <td><?php echo $member->getFirstName() ?></td>
    <td><?php echo $member->getSex() ?></td>
    <td><?php echo $member->getEmail() ?></td>
    <td><?php echo $member->getLastActivity('m/d/Y') ?></td>
    <td><?php echo $message->getMemberRelatedByToMemberId()->getUsername() ?></td>
    <td class="profile_link"><?php echo link_to('Profile', '#') ?></td>
    <td class="preview_button">
        <?php echo button_to_remote('Preview', array('url' => 'ajax/getMessageById?id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()) ?>
    </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'messages/list')); ?>
<div id="preview"></div>