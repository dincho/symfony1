<?php echo __('Photos Authenticity Instructions'); ?>

<?php echo form_tag('editProfile/photoAuthenticity', array('id' => 'edit_photos')) ?>
    <h3><?php echo __('Public Photos'); ?></h3><hr />
    <?php $cnt_photos = count($public_photos); ?>
    <?php $free_photos_cnt = 0; ?>

    <?php if($cnt_photos > 0): ?>
        <div class="photos">
            <label id="main_photo"><?php echo __('Main Photo'); ?></label>
            
            <?php foreach ($public_photos as $photo): ?>
                <div class="photo_container">
                    <div class="photo">
                        <?php if( !$photo->getAuth() ): ?>
                          <?php echo radiobutton_tag('auth_photo_id', $photo->getId(), null, array('id' => 'main_photo')) ?>
                        <?php endif; ?>
                        
                        <?php if( $photo->getAuth() ): ?>
                            <label>
                                <?php if( $photo->getAuth() == 'S' ): ?>
                                    <?php echo __('Submitted'); ?>
                                <?php elseif($photo->getAuth() == 'A' ): ?>
                                    <?php echo __('Approved'); ?>
                                <?php elseif( $photo->getAuth() == 'D' ): ?>
                                    <?php echo __('Denied'); ?>
                                <?php endif;?>
                            </label><br />
                        <?php else: ?>
                            <?php $free_photos_cnt++; ?>
                        <?php endif;?>
                        
                    <span>
                        <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                    </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <br class="clear" />
    <p class="photo_authenticity"><?php echo ($member->hasAuthPhoto()) ? __('your photo is verified') : __('photo authenticity not verified'); ?></p>
    <br class="clear" />
    <hr />
   <h3><?php echo __('Private Photos'); ?></h3><hr />
    <?php $cnt_photos = count($private_photos); ?>

    <?php if($cnt_photos > 0): ?>
        <div class="photos">
            <?php foreach ($private_photos as $photo): ?>
                <div class="photo_container">
                    <div class="photo">
                        <?php if( !$photo->getAuth() ): ?>
                          <?php echo radiobutton_tag('auth_photo_id', $photo->getId(), null, array('id' => 'main_photo')) ?>
                        <?php endif; ?>
                        
                        <?php if( $photo->getAuth() ): ?>
                            <label>
                                <?php if( $photo->getAuth() == 'S' ): ?>
                                    <?php echo __('Submitted'); ?>
                                <?php elseif($photo->getAuth() == 'A' ): ?>
                                    <?php echo __('Approved'); ?>
                                <?php elseif( $photo->getAuth() == 'D' ): ?>
                                    <?php echo __('Denied'); ?>
                                <?php endif;?>
                            </label><br />
                        <?php else: ?>
                            <?php $free_photos_cnt++; ?>
                        <?php endif;?>
                        
                    <span>
                        <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
                    </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br class="clear" />
    
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