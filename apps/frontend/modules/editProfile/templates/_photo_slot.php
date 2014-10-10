<?php use_helper('Javascript'); ?>

<div class="photo" id="<?php echo 'photo_' . $photo->getId(); ?>">
    <div class="top_actions">
        <?php echo button_to_remote(
            'x',
            array(
                'url'    => $sf_params->get('module') . '/confirmDeletePhoto?id=' . $photo->getId(),
                'update' => 'msg_container',
                'after'  => 'scroll(0,0)',
            ),
            array('class' => 'button_mini tool_button')
        ) ?>
        <?php echo button_to_function(
            'crop',
            strtr(
                'show_crop_area("%ID%", "%ORIGINAL_PHOTO%", this)',
                array(
                    '%ID%'             => $photo->getId(),
                    '%ORIGINAL_PHOTO%' => $photo->getImageUrlPath('file'),
                )
            ),
            array('class' => 'button_mini tool_button')
        ) ?>
        <?php echo button_to_function(
            '↶',
            'rotate("' . url_for(
                'editProfile/rotatePhoto?member_id=' . $photo->getMemberId()
            ) . '", ' . $photo->getId() . ', 90)',
            array('class' => 'button_mini tool_button')
        ) ?>
        <?php echo button_to_function(
            '↷',
            'rotate("' . url_for(
                'editProfile/rotatePhoto?member_id=' . $photo->getMemberId()
            ) . '", ' . $photo->getId() . ', -90)',
            array('class' => 'button_mini tool_button')
        ) ?>
    </div>
    <div class="img">
        <?php echo image_tag( $photo->getImg('100x100') ) ?>
    </div>

    <?php echo draggable_element("photo_" . $photo->getId(), array(
                                    'revert' => 'true',
                                    'onStart' => 'function (draggable, event) { draggable.element.parentNode.style.zIndex = 50; } ', //IE float+zindex FIX
                                    'onEnd' => 'function (draggable, event) { draggable.element.parentNode.style.zIndex = 0; } ', //IE float+zindex FIX
                                )); ?>
</div>
