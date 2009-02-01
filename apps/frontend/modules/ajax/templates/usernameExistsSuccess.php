<?php if( isset($error_msg) ): ?>
    <p class="msg_error"><?php echo __($error_msg, array('%USERNAME%' => $username)) ?></p>
<?php else: ?>
    <p class="msg_ok"><?php echo __('Congratulations, your username "%USERNAME%" is available.', array('%USERNAME%' => $username)) ?></p>
    <script type="text/javascript">
        $("label_username").className = "";
        var msgs = $("msgs");
        if( msgs.childNodes.length == 3 ) 
        {
            msgs.hide();
        } else {
            if($("msg_error_username")) $("msg_error_username").remove();
        }
    </script>
<?php endif; ?>