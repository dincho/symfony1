<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<br /><br />

<div class="legend"><?php echo $imbra->getImbraStatus() ?> IMBRA Application</div>
<?php include_partial('imbra/edit', array('member' => $member, 'imbra' => $imbra)); ?>
<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>