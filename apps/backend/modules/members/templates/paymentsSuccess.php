<?php use_helper('Number'); ?>
<?php echo button_to('Send Email', 'feedback/compose?mail_to=' . $member->getEmail() . '&username=' . $member->getUsername(), 'class=float-right') ?>
<?php include_partial('members/profile_pager', array('member' => $member)); ?>
<br /><br />

<div class="legend">Payments</div>

<?php include_partial('members/subMenu', array('member' => $member, 'class' => 'top')); ?>

<table class="zebra" style="margin-top: 18px;">
    <thead>
        <tr>
            <th>Last Changes</th>
            <th>Type</th>
            <th>Subscription ID</th>
            <th>Processor</th>
            <th>Price</th>
            <th>Status</th>
            <th>Processor REF.</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach($payments as $payment): ?>
        <tr>
            <td><?php echo $payment->getUpdatedAt('m/d/Y H:i'); ?></td>
            <td><?php echo $payment->getPaymentType() ?></td>
            <td><?php echo $payment->getMemberSubscriptionId() ?></td>
            <td><?php echo $payment->getPaymentProcessor() ?></td>
            <td><?php echo format_currency($payment->getAmount(), $payment->getCurrency()) ?></td>
            <td><?php echo $payment->getStatus(); ?></td>
            <td><?php echo $payment->getPPRef(); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  
</table>

<?php include_partial('members/subMenu', array('member' => $member)); ?>