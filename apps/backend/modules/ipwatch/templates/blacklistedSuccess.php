<?php use_helper('Number', 'Javascript') ?>

<table class="zebra reports">
  <thead>
      <tr>
          <th>IP</th>
          <th>Number of members</th>
          <th>maxmind.com location</th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $object): ?>
      <tr onclick="preview_click('<?php echo $object['ip']; ?>')"  >
          <td><?php echo long2ip($object['ip']) ?></td>
          <td><?php echo number_format($object['count'], 0, '.', ',') ?></td>
          <td><?php echo $object['location'] ?></td>
          <td class="preview_button">
              <?php echo button_to_remote('Preview', array('url' => 'ajax/getUsersByIp?ip=' . $object['ip'], 'update' => 'preview_duplicates'), 'id=preview_' . $object['ip']) ?>
          </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'ipwatch/blacklisted')); ?>
<br /><br />
<div id='preview_duplicates'>
</div>
