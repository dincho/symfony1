<?php use_helper('Javascript'); ?>

<div class="photo" id="<?php echo 'photo_' . $photo->getId(); ?>">
    <div class="top_actions">
        <?php echo button_to_remote('x', array('url' => 'editProfile/confirmDeletePhoto?id=' . $photo->getId() . '&member_id=' . $photo->getMemberId(),
                                                                 'update'  => 'msg_container'
                                                                ),
                                                           array('class' => 'delete_button')) ?>

        <?php echo button_to_function('crop', strtr('show_crop_area("%ID%", "%ORIGINAL_PHOTO%", this)', array('%ID%' => $photo->getId(), '%ORIGINAL_PHOTO%' => $photo->getImageUrlPath('file'), ) ),
                                                           array('class' => 'delete_button', )) ?>
        <?php echo button_to_function('↶', 'rotate(' . $photo->getId() . ', 90)' ,
            array('class' => 'button_mini delete_button')) ?>
        <?php echo button_to_function('↷', 'rotate(' . $photo->getId() . ', -90)' ,
            array('class' => 'button_mini delete_button')) ?>
    </div>
    <div class="img">
        <?php echo image_tag( $photo->getImg('100x100') ) ?>
    </div>

    <?php include_partial('editProfile/photo_status', array('photo' => $photo)); ?>

    <?php echo draggable_element("photo_" . $photo->getId(), array(
                                    'revert' => 'true',
                                    'onStart' => 'function (draggable, event) { draggable.element.parentNode.style.zIndex = 50; } ', //IE float+zindex FIX
                                    'onEnd' => 'function (draggable, event) { draggable.element.parentNode.style.zIndex = 0; } ', //IE float+zindex FIX
                                )); ?>
</div>
