<?php use_helper('I18N') ?>
<?php echo image_tag($photo->getImageUrlPath('cropped', '100x95')) ?><br /><br />

<?php echo form_tag('photos/addToMemberStories') ?>
    <div class="legend">Add to Member Stories</div>
    <?php echo input_hidden_tag('culture', $culture) ?>
    <?php echo input_hidden_tag('photo_id', $photo->getId()) ?>
    <table class="zebra">
        <thead>
            <tr>
                <th><?php echo format_language($culture) ?></th>
                <th>Title</th>
                <th>URL Name</th>
                <th>Replace</th>
            </tr>
        </thead>

    <?php foreach ($stories as $story): ?>
        <tr>
            <td class="marked"><?php echo checkbox_tag('marked[]', $story->getId(), null) ?></td>
            <td><?php echo $story->getTitle(); ?></td>
            <td><?php echo $story->getSlug(); ?>.html</td>
            <td>
                <?php if($story->getStockPhotoId()): ?>
                    <?php echo checkbox_tag('replace[]', $story->getId(), false) ?>
                    <?php echo image_tag($story->getStockPhoto()->getImageUrlPath('cropped', '50x50')) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </table>
    <div class="actions">
        <?php echo button_to('Cancel', 'photos/stockPhotos') ?>
        <?php echo submit_tag('Next') ?>
    </div>
</form>
<div id="bottom_menu">
  <span class="bottom_menu_title">Edit:</span>
  <ul>
    <li><?php echo link_to_unless($culture == 'en', 'English', 'photos/addToMemberStories?culture=en&photo_id=' . $photo->getId()) ?>&nbsp;|</li>
    <li><?php echo link_to_unless($culture == 'pl', 'Polish', 'photos/addToMemberStories?culture=pl&photo_id=' . $photo->getId()) ?>&nbsp;</li>
  </ul>
</div>
