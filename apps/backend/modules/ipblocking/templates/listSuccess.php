<?php use_helper('Javascript', 'Number') ?>

<?php echo form_tag('ipblocking/update') ?>
    <?php echo input_hidden_tag('culture', $culture) ?>
    <table class="zebra">
        <thead>
            <tr class="top_actions">
                <td colspan="4"><?php echo button_to ('New', 'ipblocking/add?culture=' . $culture) ?></td>
            </tr>            
            <tr>
                <th></th>
                <th>Item</th>
                <th>Created</th>
            </tr>
        </thead>
        
    <?php foreach ($pager->getResults() as $object): ?>
        <tr rel="<?php echo url_for('ipblocking/edit?id=' . $object->getId()) ?>">
            <td class="marked"><?php echo checkbox_tag('marked[]', $object->getId(), null) ?></td>
            <td><?php echo $object->getItem(); ?>
        	    <?php if ($object->getItemType() == 3):?>
        	    /<?php echo $object->getNetmask();?>
        	    <?php endif;?>
	        </td>
            <td><?php echo $object->getCreatedAt('d.m.Y H:i'); ?></td>
        </tr>
    <?php endforeach; ?>
    
    </table>
    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'ipblocking/list')); ?>

    <div class="actions">
        <?php echo submit_tag('Delete', 'id=delete name=delete confirm=Are you sure you want to delete selected blocks?') ?>
    </div>    
</form>


