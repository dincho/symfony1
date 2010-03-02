<?php echo __('Photos Authenticity Instructions'); ?>

<?php echo form_tag('editProfile/photoAuthenticity', array('id' => 'edit_photos')) ?>
    <?php $cnt_photos = count($photos); ?>
    <?php $free_photos_cnt = 0; ?>
    
    <?php if($cnt_photos > 0): ?>
        <div class="photos">
            <?php $i=1;foreach ($photos as $photo): ?>
              <div class="photo">
                    <?php if( !$photo->getAuth() ): ?>
                      <?php echo radiobutton_tag('auth_photo_id', $photo->getId(), null, array('id' => 'main_photo')) ?>
                    <?php endif; ?>
                  
                    <label for="main_photo">
                        <?php if( $photo->getAuth() == 'S' ): ?>
                            <?php echo __('Submitted'); ?>
                        <?php elseif($photo->getAuth() == 'A' ): ?>
                            <?php echo __('Approved'); ?>
                        <?php elseif( $photo->getAuth() == 'D' ): ?>
                            <?php echo __('Denied'); ?>
                        <?php else: ?>
                            <?php $free_photos_cnt++; ?>
                        <?php endif;?>
                    </label><br />
                <span>
                    <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                </span>
              </div>
        <?php if( $i++ % 5 == 0 && $i <= $cnt_photos): ?>
        </div>
        <div class="photos">
        <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <p class="photo_authenticity float-right"><?php echo ($member->hasAuthPhoto()) ? __('photo authenticity verified') : __('photo authenticity not verified'); ?></p>
    <br class="clear" />
    <hr />
    
    <fieldset>
        <br /><br /><?php echo link_to(__('Cancel and go to photos'), 'editProfile/photos', array('class' => 'sec_link_small')) ?><br />
        <?php if( $free_photos_cnt > 0 ): ?>
            <?php echo submit_tag(__('Submit Authenticity Request'), array('class' => 'button', 'name' => 'save')) ?>
        <?php endif; ?>
    </fieldset>
    
</form>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>