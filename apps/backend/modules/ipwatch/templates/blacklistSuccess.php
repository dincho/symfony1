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
        
    <?php foreach ($ipwatch as $ip): ?>
        <tr rel="<?php echo url_for('ipwatch/editWatch?id=' . $ip->getId()) ?>">
            <td class="marked"><?php echo checkbox_tag('marked[]', $ip->getId(), null) ?></td>
            <td><?php echo long2ip($ip->getIp()); ?></td>
            <td><?php echo $ip->getCreatedAt('d.m.Y H:i'); ?></td>
        </tr>
    <?php endforeach; ?>
    
    </table>
    <div class="actions">
        <?php echo submit_tag('Delete', 'id=delete name=delete confirm=Are you sure you want to delete selected IP?') ?>
    </div>    
</form>


