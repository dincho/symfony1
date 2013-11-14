<?php include_component('members', 'profilePager', array('member' => $member)); ?>

<div class="legend"><?php echo ($imbra) ? $imbra->getImbraStatus() : '' ?> IMBRA Application</div>
<?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>
<?php include_partial('imbra/edit', array('member' => $member, 'imbra' => $imbra)); ?>
<?php include_partial('members/subMenu', array('member' => $member)); ?>
