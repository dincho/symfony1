<?php echo link_to(hover_image_tag('list.png','list_over.png'), 'photos/list', array('query_string' => 'filter=filter&filters[is_list]=1&page='.$sf_params->get('page',1) . $query_string)); ?> 
<?php echo image_tag('grid_sel.png') ?>

<?php $i=0; ?>
<?php foreach($pager->getResults() as $member): ?>
    <?php if( $i++ % $grid_per_row == 0 ): ?>
      <fieldset class="form_fields">
    <?php endif; ?>             
    <?php $photo = $member->getMainPhoto(); ?>
        <div class="photo_slot" id="<?php echo 'photo_' . $photo->getId(); ?>">
            <div class="photo_headline"><b><?php echo $member->getUsername() ?></b>
            </div>
            <div >
                <?php echo link_to(image_tag( ($photo->getImageFilename('cropped')) ? $photo->getImageUrlPath('cropped', '100x100') : $photo->getImageUrlPath('file', '100x100') ), 'members/editPhotos?id=' . $member->getId() . '&photo_id=' . $photo->getId()) ?><br />
            </div>
        </div>
            

        <?php if( $i % $grid_per_row == 0 ): ?>
          </fieldset><br />
        <?php endif; ?>             
<?php endforeach; ?>
</fieldset><br />
