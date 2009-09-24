<?php if( isset($error_msg) ): ?>
    <p class="msg_error"><?php echo $error_msg; ?></p>
<?php else: ?>
    <p class="msg_ok"><?php echo $ok_msg; ?></p>
    <script type="text/javascript">
        $("label_username").className = "";
        var msgs = $("msgs");
        if( msgs && msgs.childNodes.length == 3 ) 
        {
            msgs.hide();
        } else {
            if($("msg_error_username")) $("msg_error_username").remove();
        }
    </script>
<?php endif; ?>