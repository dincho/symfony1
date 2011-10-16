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
      <tr onclick="preview_click('<?php echo $object->getIp(); ?>')"  >
          <td><?php echo long2ip($object->getIp()) ?></td>
          <td><?php echo number_format($object->getCount(), 0, '.', ',') ?></td>
          <td><?php echo $object->getLocation() ?></td>
          <td class="preview_button">
              <?php echo button_to_remote('Preview', array('url' => 'ajax/getUsersByIp?ip=' . $object->getIp(), 'update' => 'preview_duplicates'), 'id=preview_' . $object->getIp()) ?>
          </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'ipwatch/blacklisted')); ?>
<br /><br />
<div id='preview_duplicates'>
</div>