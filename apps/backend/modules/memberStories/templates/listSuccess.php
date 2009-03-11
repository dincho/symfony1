<?php use_helper('Javascript', 'Number', 'xSortableTitle') ?>

<?php echo form_tag('memberStories/update') ?>
    <?php echo input_hidden_tag('culture', $culture) ?>
    <table class="zebra">
        <thead>
            <tr class="top_actions">
                <td colspan="4"><?php echo button_to ('New', 'memberStories/add?culture=' . $culture) ?></td>
            </tr>            
            <tr>
                <th></th>
                <th><?php echo sortable_title('Sort Order', 'MemberStory::sort_order', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Name', 'MemberStory::title', $sort_namespace) ?></th>
                <th><?php echo sortable_title('URL Name', 'MemberStory::slug', $sort_namespace) ?></th>
            </tr>
        </thead>
        
    <?php foreach ($stories as $story): ?>
        <tr rel="<?php echo url_for('memberStories/edit?id=' . $story->getId()) ?>">
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
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'memberStories/list?culture=en') ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'memberStories/list?culture=pl') ?>&nbsp;</li>
  </ul>
</div>