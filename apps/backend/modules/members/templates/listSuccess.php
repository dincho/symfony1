<?php use_helper('Number', 'xSortableTitle', 'prProfilePhoto') ?>

<div class="filter_right">
    Total (All Members): <?php echo format_number($pager->getNbResults()) ?>
    <?php echo button_to('Add Member', 'members/create') ?>
</div>

<?php include_partial('members/search_filter', array('filters' => $filters)); ?>

<table class="zebra">
  <thead>
    <tr>
      <th></th>
      <th class="firstcolumn"></th>
      <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('ID', 'Member::id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('First name', 'Member::first_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Domain', 'Member::catalog_id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sex', 'Member::sex', $sort_namespace) ?></th>
      <th><?php echo sortable_title('For', 'Member::looking_for', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Email', 'Member::email', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Joined', 'Member::created_at', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sub', 'Member::subscription_id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Reviewed', 'Member::reviewed_by_id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Status', 'Member::member_status_id', $sort_namespace) ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $member): ?>
  <tr rel="<?php echo url_for('members/edit?id=' . $member->getId()); ?>">
    <td class="starred"><?php echo link_to(($member->IsStarred()) ? image_tag('star_yellow.png') : image_tag('star_gray.png'), 'members/star?id=' . $member->getId()) ?></td>
    <td class="skip_me"><?php echo link_to(unless_profile_thumbnail_photo_tag($member), $member->getFrontendProfileUrl(), array('popup' => true) ) ?></td>
    <td><?php echo $member->getUsername() ?></td>
    <td><?php echo $member->getId() ?></td>
    <td><?php echo $member->getFirstName() ?></td>
    <td><?php if ($member->getCatalogue()) echo $member->getCatalogue()->getDomain() ?></td>
    <td><?php echo $member->getSex() ?></td>
    <td><?php echo $member->getLookingFor() ?></td>
    <td><?php echo $member->getEmail() ?></td>
    <td><?php echo $member->getCreatedAt('m/d/Y') ?></td>
    <td><?php echo $member->getSubscription()->getShortTitle() ?></td>
    <td><?php if($member->getReviewedById()) echo $member->getUser() ?></td>
    <td class="member_status"><?php echo content_tag('span', $member->getMemberStatus(), array('class' => strtolower($member->getMemberStatus()))) ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'members/list')); ?>
