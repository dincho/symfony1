<div id="photos">
    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/stockPhotos')); ?><br />
    
    <fieldset class="form_fields">
    <?php $i=1; foreach($pager->getResults() as $photo): ?>
        <div class="photo_slot">
            <?php echo image_tag( $photo->getImageUrlPath('file', '100x95') ) ?><br />
            <?php echo (is_null($photo->getHomepages()) ? '&nbsp;&nbsp;&nbsp;' : '+&nbsp;') .  link_to('Home Page', 'photos/addToHomepage?photo_id=' . $photo->getId()) ?><br />
            <?php echo (($photo->countMemberStorys() < 1) ? '&nbsp;&nbsp;&nbsp;' : '+&nbsp;') . link_to('Member Stories', 'photos/addToMemberStories?photo_id=' . $photo->getId()) ?><br />
            <?php echo (is_null($photo->getAssistants()) ? '&nbsp;&nbsp;&nbsp;' : '+&nbsp;') .  link_to('Assistant', 'photos/addToAssistant?photo_id=' . $photo->getId()) ?><br />
            <?php echo (is_null($photo->getJoinNow()) ? '&nbsp;&nbsp;&nbsp;' : '+&nbsp;') .  link_to('Join Now', 'photos/addToJoinNow?photo_id=' . $photo->getId()) ?><br />
            <?php echo link_to('&nbsp;&nbsp;&nbsp;Delete Photo', 'photos/deleteStockPhoto?id='.$photo->getId(), 'confirm=Are you sure you want to delete this photo?') ?><br />
        </div>
        <?php if( $i++ % 6 == 0 ): ?>
            </fieldset>
            <br />
            <fieldset class="form_fields">
        <?php endif; ?>
    <?php endforeach; ?>
    </fieldset><br />
    
    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/stockPhotos')); ?><br />
    
</div>
