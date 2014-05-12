<?php use_helper('xSortableTitle') ?>

<?php echo form_tag(sfContext::getInstance()->getModuleName() . '/' . sfContext::getInstance()->getActionName(), array('method' => 'get', 'id' => 'search_filter')) ?>
    <?php echo input_hidden_tag('filter', 'filter', 'class=hidden') ?>
    <fieldset class="search_fields">
        <label for="filters[subscr_id]">Subscription ID:</label><br />
        <?php echo input_tag('filters[subscr_id]', ( isset($filters['subscr_id']) ) ? $filters['subscr_id'] : null) ?><br />

        <label for="query">Type:</label><br />
        <?php echo input_tag('filters[txn_type]', ( isset($filters['txn_type']) ) ? $filters['txn_type'] : null) ?>
    </fieldset>
    <fieldset>
        <label for="search">&nbsp;</label><br />
        <?php echo submit_tag('Search', 'id=search') ?>
    </fieldset>
</form>

<table class="zebra">
  <thead>
    <tr>
      <th><?php echo sortable_title('Type', 'IpnHistory::txn_type', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Subscription ID', 'IpnHistory::subscr_id', $sort_namespace) ?></th>
      <th><?php echo sortable_title('Status', 'IpnHistory::payment_status', $sort_namespace) ?></th>
      <th>Item Number</th>
      <th>Custom</th>
      <th><?php echo sortable_title('Date/Time', 'IpnHistory::created_at', $sort_namespace) ?></th>
      <th>PP Date/Time</th>
      <th>IP</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pager->getResults() as $history): ?>
  <tr rel="<?php echo url_for('IPNHistory/details?id=' . $history->getId()); ?>">
    <td><?php echo $history->getTxnType() ?></td>
    <td><?php echo $history->getSubscrId() ?></td>
    <td><?php echo $history->getPaymentStatus() ?>
    <td><?php echo $history->getParam('item_number'); ?></td>
    <td><?php echo $history->getParam('custom'); ?></td>
    <td><?php echo $history->getCreatedAt() ?></td>
    <td><?php echo $history->getTxnCreatedAt() ?></td>
    <td><?php echo long2ip($history->getRequestIp()) ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'IPNHistory/list')); ?>
