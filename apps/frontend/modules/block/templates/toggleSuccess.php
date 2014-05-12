<?php include_partial('content/messages'); ?>

<?php if( $sf_params->get("update_selector") ): ?>
    <?php if( $block->isDeleted() ): ?>
        <script type="text/javascript" charset="utf-8">
            $('<?php echo $sf_params->get("update_selector");?>').update('<?php echo __("Block"); ?>');
        </script>
    <?php else: ?>
        <script type="text/javascript" charset="utf-8">
            $('<?php echo $sf_params->get("update_selector");?>').update('<?php echo __("Unblock"); ?>');
        </script>
    <?php endif; ?>
<?php endif; ?>

<?php if( $sf_params->get("undo") && $sf_params->get("show_element") ): ?>
    <script type="text/javascript" charset="utf-8">
        $('<?php echo $sf_params->get("show_element");?>').show();
    </script>
<?php endif; ?>
