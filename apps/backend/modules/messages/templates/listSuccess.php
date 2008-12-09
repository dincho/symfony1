<?php echo use_helper('Javascript', 'Number', 'xSortableTitle') ?>

<div class="filter_right">Total: <?php echo format_number($pager->getNbResults()) ?></div>
<?php include_partial('members/search_filter', array('filters' => $filters)); ?>


<table class="zebra">
  <thead>
    <tr>
      <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('ID', 'Member::id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Last name', 'Member::last_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('First name', 'Member::first_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sex', 'Member::sex', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Email', 'Member::email', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Last Activity', 'Member::last_activity', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sent To', 'Message::to_member_id', $sort_namespace) ?></th>      
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $message): ?>
  <?php $member = $message->getMemberRelatedByFromMemberId(); //shortcut ?>
  <tr rel="<?php echo url_for('messages/conversation?id=' . $message->getId()) ?>" onmouseover="preview_click('<?php echo $message->getId();?>')" onmouseout2="preview_clear();">
    <td><?php echo $member->getUsername() ?></td>
    <td><?php echo $member->getId() ?></td>
    <td><?php echo $member->getLastName() ?></td>
    <td><?php echo $member->getFirstName() ?></td>
    <td><?php echo $member->getSex() ?></td>
    <td><?php echo $member->getEmail() ?></td>
    <td><?php echo $member->getLastActivity('m/d/Y') ?></td>
    <td><?php echo $message->getMemberRelatedByToMemberId()->getUsername() ?></td>
    <td class="profile_link"><?php echo link_to('Profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
    <td class="preview_button">
        <?php echo button_to_remote('Preview', array('url' => 'ajax/getMessageById?id=' . $message->getId(), 'update' => 'preview'), 'id=preview_' . $message->getId()) ?>
    </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'messages/list')); ?>
<div id="preview"></div>