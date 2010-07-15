<?php use_helper('Javascript'); ?>

<div id="messages">
    <div class="msg_error">
        <?php echo strtr('Are you sure you want to delete selected photo? <a onclick="%JS_FOR_CANCEL%" class="sec_link" href="#">No</a> <a onclick="%JS_FOR_CONFIRM%" class="sec_link" href="#">Yes</a>',
                        array('%JS_FOR_CANCEL%'  => '$(\'messages\').remove(); return false;', 
                              '%JS_FOR_CONFIRM%' => '' . remote_function(array('url' => 'editProfile/deletePhoto?id=' . $sf_params->get('id') . '&member_id=' . $member->getId(),
                                                                                           'update' => 'msg_container',
                                                                                           'script' => true, 
                                                                    )),
                              )
                     ); ?>
    </div>
</div>