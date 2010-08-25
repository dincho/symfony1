<?php use_helper('Javascript'); ?>

<div class="photo" id="<?php echo 'photo_' . $photo->getId(); ?>">
    <div class="top_actions">
        <?php echo button_to_remote('x', array('url' => $sf_params->get('module').'/confirmDeletePhoto?id=' . $photo->getId(),
                                                                 'update'  => 'msg_container',
                                                                 'after'   => 'scroll(0,0)',
                                                                ),
                                                           array('class' => 'button_mini delete_button')) ?>
    </div>                                
    <div class="img">
        <?php echo image_tag( $photo->getImageUrlPath('file', '100x100') ) ?>
    </div>

    <?php echo draggable_element("photo_" . $photo->getId(), array(
                                    'revert' => 'revertEffect',
                                    'onStart' => 'function(draggable, event) { draggable.element.parentNode.style.zIndex = 50; } ', //IE float+zindex FIX
                                    'onEnd' => 'function(draggable, event) { draggable.element.parentNode.style.zIndex = 0; } ', //IE float+zindex FIX
                                )); ?>
</div>