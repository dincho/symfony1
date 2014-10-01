<?php use_helper('Javascript'); ?>

<div id="msgs">
    <p class="msg_error">
        <?php echo __('Are you sure you want to delete selected photo? <a onclick="%JS_FOR_CANCEL%" class="sec_link" href="#">No</a> <a onclick="%JS_FOR_CONFIRM%" class="sec_link" href="#">Yes</a>',
                        array('%JS_FOR_CANCEL%'  => '$(\'msgs\').remove(); return false;',
                              '%JS_FOR_CONFIRM%' => '' . remote_function(array('url' => $sf_params->get('module').'/deletePhoto?id=' . $sf_params->get('id'),
                                                                                           'update' => 'msg_container',
                                                                                           'script' => true,
                                                                    )),
                              )
                     ); ?>
    </p>
</div>
