<?php use_helper('Number') ?>

<div class="filter_right">
    Total (All Members): <?php echo format_number($pager->getNbResults()) ?>
    <?php echo button_to('Add Member', '#') ?>
</div>

<?php include_partial('members/search_filter', array('filters' => $filters)); ?>

    

<table class="zebra">
  <thead>
    <tr>
      <th></th>
      <th>Username</th>
      <th>ID</th>
      <th>Last name</th>
      <th>First name</th>
      <th>Sex</th>
      <th>Email</th>
      <th>Joined</th>
      <th>Sub</th>
      <th>Reviewed</th>
      <th>Status</th>
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
    <td><?php echo $member->getEmail() ?></td>
    <td><?php echo $member->getCreatedAt('m/d/Y') ?></td>
    <td><?php echo $member->getSubscription()->getShortTitle() ?></td>
    <td><?php if($member->getReviewedById()) echo $member->getUser() ?></td>
    <td class="member_status"><?php echo content_tag('span', $member->getMemberStatus(), array('class' => strtolower($member->getMemberStatus()))) ?></td>
    <td class="skip_me"><?php echo link_to('Profile', $sf_request->getUriPrefix() . '/profile/' . $member->getUsername(), array('popup' => true)) ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'members/list')); ?>
