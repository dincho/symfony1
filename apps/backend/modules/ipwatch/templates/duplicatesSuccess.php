<?php use_helper('Number', 'Javascript') ?>

<?php echo form_tag('ipwatch/AddToList') ?>
    <div class="actions">
        <?php echo submit_tag('Add to Blacklist', 'id=add_to_blacklist name=add_to_blacklist') ?>
        <?php echo submit_tag('Add to IP Blocking', 'id=add_to_block name=add_to_block') ?>
    </div>    

<table class="zebra reports">
  <thead>
      <tr>
          <th></th>
          <th>IP</th>
          <th>Number of members</th>
          <th>maxmind.com location</th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $object): ?>
      <tr onclick="preview_click('<?php echo $object->getIp(); ?>')"  >
          <td class="marked"><?php echo checkbox_tag('marked[]', $object->getIp(), null) ?></td>
          <td><?php echo long2ip($object->getIp()) ?></td>
          <td><?php echo number_format($object->getCount(), 0, '.', ',') ?></td>
          <td><?php echo Maxmind::getMaxmindLocation(long2ip($object->getIp())) ?></td>
          <td class="preview_button">
              <?php echo button_to_remote('Preview', array('url' => 'ajax/getUsersByIp?ip=' . $object->getIp(), 'update' => 'preview_duplicates'), 'id=preview_' . $object->getIp()) ?>
          </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'ipwatch/duplicates')); ?>
<br /><br />
<div id='preview_duplicates'>
</div>
</form>