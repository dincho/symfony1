<?php use_helper('Number') ?>

<div id="filter">
    <?php include_partial('members/search_filter', array('filters' => $filters)); ?>
</div>

<?php echo form_tag('feedback/addEmailRecipients') ?>
<table class="zebra">
  <thead>
    <tr>
      <th></th>
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
    </tr>
  </thead>
  <tbody>
  <?php foreach ($members as $member): ?>
  <tr>
    <td class="marked"><?php echo checkbox_tag('marked[]', $member->getUsername(), null) ?></td>
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
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php echo submit_tag('Add') ?>
</form>