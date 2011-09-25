<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail() . '&username=' . $member->getUsername(), 'class=float-right') ?>
<?php include_component('members', 'profilePager', array('member' => $member)); ?>
<br /><br />

<div class="legend"><?php echo ($imbra) ? $imbra->getImbraStatus() : '' ?> IMBRA Application</div>
<?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>
<?php include_partial('imbra/edit', array('member' => $member, 'imbra' => $imbra)); ?>
<?php include_partial('members/subMenu', array('member' => $member)); ?>