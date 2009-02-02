<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail(), 'class=float-right') ?>
<br /><br />

<div class="legend">Status History</div>

<table class="zebra">
  <tr>
  </tr>
  <?php $cnt = count($history); ?>
  <?php for($i=0; $i<$cnt; $i++): ?>
	  <tr>
	    <td><?php echo $history[$i]->getMemberStatus()->getTitle() ?></td>
	    <?php if( isset($history[$i-1]) ): ?>
	     <td><?php echo $history[$i]->getCreatedAt('m/d/Y') ?> - <?php echo  $history[$i-1]->getCreatedAt('m/d/Y') ?></td>
	    <?php else: ?>
	     <td><?php echo $history[$i]->getCreatedAt('m/d/Y') ?> - Current</td>
	    <?php endif; ?>
	  </tr>
  <?php endfor; ?>
</table>

<?php include_partial('members/bottomMenu', array('member_id' => $member->getId())); ?>