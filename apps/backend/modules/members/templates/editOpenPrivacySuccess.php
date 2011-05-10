<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail()  . '&username=' . $member->getUsername(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Privacy Relations</div>

<?php include_partial('members/subMenu', array('member_id' => $member->getId(), 'class' => 'top')); ?>
<br />

<p>Private Dating: <?php echo ($member->getPrivateDating()) ? 'ON' : 'OFF'; ?></p>

<div id="sub_menu">
  <span class="sub_menu_title">View:</span>
  <ul>
    <li><?php echo link_to_unless(!$sf_request->getParameter('received_only'), 'Sent', 'members/editOpenPrivacy?received_only=0&id=' . $member->getId()) ?></li>
    <li><?php echo link_to_unless($sf_request->getParameter('received_only'), 'Received', 'members/editOpenPrivacy?received_only=1&id=' . $member->getId()) ?></li>
  </ul>
</div>

<br />

<table class="zebra" style="margin-top: 18px;">
    <thead>
        <tr>
            <th>Username</th>
            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($open_privacy_rows as $open_privacy): ?>
            <?php $mid = ($sf_request->getParameter('received_only')) ? $open_privacy->getMemberId() : $open_privacy->getProfileId();?>
            <tr rel="<?php echo url_for('members/edit?id=' . $mid); ?>">
                <?php if ($sf_request->getParameter('received_only')): ?>
                    <td><?php echo $open_privacy->getMemberRelatedByMemberId()->getUsername() ?></td>
                <?php else: ?>
                    <td><?php echo $open_privacy->getMemberRelatedByProfileId()->getUsername() ?></td>
                <?php endif; ?>
                <td><?php echo $open_privacy->getCreatedAt('m/d/Y') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_partial('members/subMenu', array('member_id' => $member->getId())); ?>