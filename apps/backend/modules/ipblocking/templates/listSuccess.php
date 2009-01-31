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
        
    <?php foreach ($ipblocks as $block): ?>
        <tr rel="<?php echo url_for('ipblocking/edit?id=' . $block->getId()) ?>">
            <td class="marked"><?php echo checkbox_tag('marked[]', $block->getId(), null) ?></td>
            <td><?php echo $block->getItem(); ?>
	    <?php if ($block->getItemType() == 3):?>
	    /<?php echo $block->getNetmask();?>
	    <?php endif;?>
	    </td>
            <td><?php echo $block->getCreatedAt('d.m.Y H:i'); ?></td>
        </tr>
    <?php endforeach; ?>
    
    </table>
    <div class="actions">
        <?php echo submit_tag('Delete', 'id=delete name=delete confirm=Are you sure you want to delete selected blocks?') ?>
    </div>
</form>
<?php /* ?>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'memberStories/list?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'memberStories/list?culture=pl') ?>&nbsp;</li>
  </ul>
</div>
<?php */ ?>
