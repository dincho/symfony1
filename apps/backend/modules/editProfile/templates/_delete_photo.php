<?php include_partial('system/messages'); ?>
<script type="text/javascript" charset="utf-8">
    <?php if( $sf_params->get('simple_delete') ): ?>
        $("photo_<?php echo $sf_params->get('id'); ?>").remove();
    <?php else: ?>
        delete_photo('<?php echo $sf_params->get('id');?>');
    <?php endif; ?>
</script>
