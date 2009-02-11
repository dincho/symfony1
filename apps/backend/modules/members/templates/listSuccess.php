<?php use_helper('Number', 'xSortableTitle') ?>

<div class="filter_right">
    Total (All Members): <?php echo format_number($pager->getNbResults()) ?>
    <?php echo button_to('Add Member', 'members/create') ?>
</div>

<?php include_partial('members/search_filter', array('filters' => $filters)); ?>

<table class="zebra" style="position: absolute; left: 260px; top: 220px;">
  <thead>
    <tr>
      <th></th>
      <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('ID', 'Member::id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Last name', 'Member::last_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('First name', 'Member::first_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sex', 'Member::sex', $sort_namespace) ?></th>
      <th><?php echo sortable_title('For', 'Member::looking_for', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Email', 'Member::email', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Joined', 'Member::created_at', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sub', 'Subscription::title', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Reviewed', 'User::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Status', 'MemberStatus::title', $sort_namespace) ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $member): ?>
  <tr rel="<?php echo url_for('members/edit?id=' . $member->getId()); ?>">
    <td class="starred"><?php echo link_to(($member->IsStarred()) ? image_tag('star_yellow.png') : image_tag('star_gray.png'), 'members/star?id=' . $member->getId()) ?></td>
    <td><?php echo $member->getUsername() ?></td>
    <td><?php echo $member->getId() ?></td>
    <td><?php echo $member->getLastName() ?></td>
    <td><?php echo $member->getFirstName() ?></td>
    <td><?php echo $member->getSex() ?></td>
    <td><?php echo $member->getLookingFor() ?></td>
    <td><?php echo $member->getEmail() ?></td>
    <td><?php echo $member->getCreatedAt('m/d/Y') ?></td>
    <td><?php echo $member->getSubscription()->getShortTitle() ?></td>
    <td><?php if($member->getReviewedById()) echo $member->getUser() ?></td>
    <td class="member_status"><?php echo content_tag('span', $member->getMemberStatus(), array('class' => strtolower($member->getMemberStatus()))) ?></td>
    <td class="skip_me"><?php echo link_to('Profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'members/list')); ?>
