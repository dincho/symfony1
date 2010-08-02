<?php use_helper('Window'); ?>

<script type="text/javascript" charset="utf-8">
    
    <?php echo prototype_window('send_message', array('title'        => __('Send Message to %USERNAME%', array('%USERNAME%' => $recipient->getUsername())), 
                                                    'url'            => 'messages/send?layout=window&recipient_id=' . $recipient->getId(), 
                                                    'id'             => '"send_message_window"', 
                                                    'width'          => '550', 
                                                    'height'         => '460',
                                                    'center'         => 'true', 
                                                    'minimizable'    => 'false',
                                                    'maximizable'    => 'false',
                                                    'closable'       => 'true', 
                                                    'destroyOnClose' => "true",
                                                    'onClose'        => 'function() { 
                                                            if($("send_message_span")) $("send_message_span").hide();
                                                            if($("send_message_link")) $("send_message_link").show();
                                                         }',
                                                    'className'      => 'polishdate',
                                                )); ?>
</script>