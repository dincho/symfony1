<?php use_helper('Javascript', 'Number', 'xSortableTitle') ?>

<?php echo form_tag('memberStories/update') ?>
    <?php echo input_hidden_tag('cat_id', $catalog->getCatId(), 'class=hidden') ?>
    <table class="zebra">
        <thead>
            <tr class="top_actions">
                <td colspan="4"><?php echo button_to ('New', 'memberStories/add?cat_id=' . $catalog->getCatId()) ?></td>
            </tr>            
            <tr>
                <th></th>
                <th><?php echo sortable_title('Sort Order', 'MemberStory::sort_order', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Name', 'MemberStory::title', $sort_namespace) ?></th>
                <th><?php echo sortable_title('URL Name', 'MemberStory::slug', $sort_namespace) ?></th>
            </tr>
        </thead>
        
    <?php foreach ($stories as $story): ?>
        <tr rel="<?php echo url_for('memberStories/edit?id=' . $story->getId() . '&cat_id='. $catalog->getCatId()) ?>">
            <td class="marked"><?php echo checkbox_tag('marked[]', $story->getId(), null) ?></td>
            <td class="marked"><?php echo input_tag('sort['.$story->getId().']', $story->getSortOrder(), 'style=width: 15px') ?>
            <td><?php echo $story->getTitle(); ?></td>
            <td><?php echo $story->getSlug(); ?>.html</td>
        </tr>
    <?php endforeach; ?>
    
    </table>
    <div class="actions">
        <?php echo submit_tag('Delete', 'id=delete name=delete confirm=Are you sure you want to delete selected stories?') ?>
        <?php echo submit_tag('Sort', 'name=sort_submit id=sort_submit') ?>
    </div>
</form>
<?php include_component('content', 'bottomMenu', array('url' => 'memberStories/list'))?>
