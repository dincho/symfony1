<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Privacy Relations</div>

<?php include_partial('members/subMenu', array('member_id' => $member->getId(), 'class' => 'top')); ?>

<br />
<div id="sub_menu">
  <span class="sub_menu_title">View:</span>
  <ul>
    <li><?php echo link_to_unless(!$sf_request->getParameter('received_only'), 'Sent', 'members/editOpenPrivacy?received_only=0&id=' . $member->getId()) ?></li>
    <li><?php echo link_to_unless($sf_request->getParameter('received_only'), 'Received', 'members/editOpenPrivacy?received_only=1&id=' . $member->getId()) ?></li>
  </ul>
</div>

<br />

<table class="zebra" style="margin-top: 18px;">
  <tr>
    <th>Username</th>
    <th>Created at</th>
  </tr>
  <?php $cnt = count($open_privacy); ?>
  <?php for($i=0; $i<$cnt; $i++): ?>
      <tr>
        <?php if ($sf_request->getParameter('received_only')): ?>
          <td><?php echo $open_privacy[$i]->getMemberRelatedByMemberId()->getUsername() ?></td>
        <?php else: ?>
          <td><?php echo $open_privacy[$i]->getMemberRelatedByProfileId()->getUsername() ?></td>
        <?php endif; ?>
        <td><?php echo $open_privacy[$i]->getCreatedAt('m/d/Y') ?></td>
      </tr>
  <?php endfor; ?>
</table>

<?php include_partial('members/subMenu', array('member_id' => $member->getId())); ?>