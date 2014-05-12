<?php use_helper('Javascript', 'Number') ?>

<?php echo form_tag('ipwatch/deleteWatch') ?>
    <table class="zebra">
        <thead>
            <tr class="top_actions">
                <td colspan="4"><?php echo button_to ('New', 'ipwatch/addWatch') ?></td>
            </tr>
            <tr>
                <th></th>
                <th>IP</th>
                <th>Created</th>
            </tr>
        </thead>

    <?php foreach ($pager->getResults() as $object): ?>
        <tr rel="<?php echo url_for('ipwatch/editWatch?id=' . $object->getId()) ?>">
            <td class="marked"><?php echo checkbox_tag('marked[]', $object->getId(), null) ?></td>
            <td><?php echo long2ip($object->getIp()); ?></td>
            <td><?php echo $object->getCreatedAt('d.m.Y H:i'); ?></td>
        </tr>
    <?php endforeach; ?>

    </table>
    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'ipwatch/blacklist')); ?>

    <div class="actions">
        <?php echo submit_tag('Delete', 'id=delete name=delete confirm=Are you sure you want to delete selected IP?') ?>
    </div>
</form>
