<?php use_helper('Javascript', 'Number') ?>

<?php echo form_tag('memberStories/update') ?>
    <table class="zebra">
        <thead>
            <tr class="top_actions">
                <td colspan="3"><?php echo button_to ('New', 'memberStories/add') ?></td>
            </tr>            
            <tr>
                <th></th>
                <th>Sort Order</th>
                <th>URL Name</th>
            </tr>
        </thead>
        
    <?php foreach ($stories as $story): ?>
        <tr rel="<?php echo url_for('memberStories/edit?id=' . $story->getId()) ?>">
            <td class="marked"><?php echo checkbox_tag('marked[]', $story->getId(), null) ?></td>
            <td class="marked"><?php echo input_tag('sort['.$story->getId().']', $story->getSortOrder(), 'style=width: 15px') ?>
            <td><?php echo $story->getSlug(); ?>.html</td>
        </tr>
    <?php endforeach; ?>
    
    </table>
    <div class="actions">
        <?php echo submit_tag('Delete', 'id=delete name=delete confirm=Are you sure you want to delete selected stories?') ?>
        <?php echo submit_tag('Sort', 'name=sort_submit id=sort_submit') ?>
    </div>
</form>
