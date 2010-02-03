<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />

<div class="legend"><?php echo ($imbra) ? $imbra->getImbraStatus() : '' ?> IMBRA Application</div>
<?php include_partial('members/subMenu', array('member_id' => $member->getId(), 'class' => 'top')); ?>
<?php include_partial('imbra/edit', array('member' => $member, 'imbra' => $imbra)); ?>
<?php include_partial('members/subMenu', array('member_id' => $member->getId())); ?>