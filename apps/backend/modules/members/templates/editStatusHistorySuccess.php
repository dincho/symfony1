<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail() . '&username=' . $member->getUsername(), 'class=float-right') ?>
<?php include_component('members', 'profilePager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Status History</div>

<?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>

<table class="zebra" style="margin-top: 18px;">
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

<?php include_partial('members/subMenu', array('member' => $member)); ?>