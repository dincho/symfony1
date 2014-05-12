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
      </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $object): ?>
      <tr onclick="preview_click('<?php echo $object['ip']; ?>')"  >
          <td class="marked"><?php echo checkbox_tag('marked[]', $object['ip'], null) ?></td>
          <td><?php echo long2ip($object['ip']) ?></td>
          <td><?php echo number_format($object['count'], 0, '.', ',') ?></td>
          <td class="preview_button">
              <?php echo button_to_remote('Preview', array('url' => 'ajax/getUsersByIp?ip=' . $object['ip'], 'update' => 'preview_duplicates'), 'id=preview_' . $object['ip']) ?>
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
