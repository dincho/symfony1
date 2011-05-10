<?php use_helper('Number'); ?>
<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail() . '&username=' . $member->getUsername(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Member Subscriptions</div>

<?php include_partial('members/subMenu', array('member_id' => $member->getId(), 'class' => 'top')); ?>

<table class="zebra" style="margin-top: 18px;">
    <thead>
        <tr>
            <th>Last Changes</th>
            <th>ID</th>
            <th>Subscription</th>
            <th>Status</th>
            <th>Period</th>
            <th>Effective Date</th>
            <th>EOT</th>
            <th>Gift By</th>
            <th>Processor REF.</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach($subscriptions as $subscription): ?>
        <tr>
            <td><?php echo $subscription->getUpdatedAt('m/d/Y H:i'); ?></td>
            <td><?php echo $subscription->getID(); ?></td>
            <td><?php echo $subscription->getSubscription()->getTitle(); ?></td>
            <td><?php echo $subscription->getStatus() . (($subscription->getId() == $currentSubscriptionId) ? ' (current)' : null); ?></td>
            <td><?php echo $subscription->getPeriod() . "&nbsp;" . $subscription->getPeriodType() ?></td>
            <td><?php echo $subscription->getEffectiveDate('m/d/Y'); ?></td>
            <td><?php echo $subscription->getEotAt('m/d/Y'); ?></td>
            <td><?php echo ($subscription->getGiftBy()) ? link_to($subscription->getGiftSender()->getUsername(), 'members/edit?id=' . $subscription->getGiftBy()) : null; ?></td>
            <td><?php echo $subscription->getPPRef(); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  
</table>

<?php include_partial('members/subMenu', array('member_id' => $member->getId())); ?>