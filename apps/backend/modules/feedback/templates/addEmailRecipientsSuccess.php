<?php use_helper('Number') ?>
<?php use_helper('Number', 'xSortableTitle') ?>

<div id="filter">
    <?php include_partial('members/search_filter', array('filters' => $filters)); ?>
</div>

<?php echo form_tag('feedback/addEmailRecipients') ?>
<table class="zebra">
  <thead>
    <tr>
      <th></th>
      <th></th>
      <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('ID', 'Member::id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Last name', 'Member::last_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('First name', 'Member::first_name', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sex', 'Member::sex', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Email', 'Member::email', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Joined', 'Member::created_at', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Sub', 'Subscription::title', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Reviewed', 'User::username', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Status', 'MemberStatus::title', $sort_namespace) ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $member): ?>
  <tr>
    <td class="marked"><?php echo checkbox_tag('marked[]', $member->getUsername(), in_array($member->getUsername(),$selectedMembers),
                                                        array('class' => 'checkbox',
                                                        'onchange' => "new Ajax.Request('". url_for('ajax/UpdateEmailRecipients?member_id=' . $member->getId()) ."', {method: 'get'});")) ?>
        </td>
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
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'feedback/addEmailRecipients')); ?>
