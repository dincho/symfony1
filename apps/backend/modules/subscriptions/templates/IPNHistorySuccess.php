<table class="zebra">
  <thead>
    <tr>
      <th>Type</th>
      <th>Subscription ID</th>
      <th>Status</th>
      <th>Date/Time</th>
      <th>IP</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($histories as $history): ?>
  <tr rel="<?php echo url_for('subscriptions/IPNHistoryDetails?id=' . $history->getId()); ?>">
    <td><?php echo $history->getParam('txn_type') ?></td>
    <td><?php echo $history->getParam('subscr_id') ?></td>
    <td><?php echo $history->getParam('payment_status') ?>
    <td><?php echo $history->getCreatedAt() ?></td>
    <td><?php echo long2ip($history->getRequestIp()) ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

