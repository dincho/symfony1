<?php use_helper('prProfilePhoto') ?>
<table class="zebra">
  <thead>
    <tr>
      <th class="firstcolumn"></th>
      <th><?php echo 'Username' ?></th>
      <th><?php echo 'ID' ?></th>
      <th><?php echo 'Last name' ?></th>
      <th><?php echo 'First name' ?></th>
      <th><?php echo 'Sex' ?></th>
      <th><?php echo 'For' ?></th>
      <th><?php echo 'Email' ?></th>
      <th><?php echo 'Joined' ?></th>
      <th><?php echo 'Sub' ?></th>
      <th><?php echo 'Reviewed' ?></th>
      <th><?php echo 'Status' ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $member): ?>
  <tr>
    <td><?php echo unless_profile_thumbnail_photo_tag($member) ?></td>
    <td><?php echo link_to($member->getUsername(), 'members/edit?id=' . $member->getId()) ?></td>
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
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
