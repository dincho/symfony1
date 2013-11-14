<?php include_component('members', 'profilePager', array('member' => $member)); ?>

<div class="legend">Subscription History</div>

<?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>

<table class="zebra" style="margin-top: 18px;">
    <tr>
        <th>Subscription</th>
        <th>Member's status</th>
        <th>Changed by</th>
        <th>Period</th>
    </tr>
    <?php $cnt = count($history); ?>
    <?php for($i=0; $i<$cnt; $i++): ?>
        <tr>
            <td><?php echo $history[$i]->getSubscription(); ?></td>
            <td><?php echo $history[$i]->getMemberStatus(); ?></td>
            <td><?php echo $history[$i]->getChangedBy(); ?></td>
            <?php if( isset($history[$i-1]) ): ?>
                <td><?php echo $history[$i]->getCreatedAt('m/d/Y') ?> - <?php echo  $history[$i-1]->getCreatedAt('m/d/Y') ?></td>
            <?php else: ?>
                <td><?php echo $history[$i]->getCreatedAt('m/d/Y') ?> - Current</td>
            <?php endif; ?>
        </tr>
    <?php endfor; ?>
</table>

<?php include_partial('members/subMenu', array('member' => $member)); ?>
