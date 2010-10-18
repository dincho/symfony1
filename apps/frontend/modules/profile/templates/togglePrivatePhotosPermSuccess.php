<?php include_partial('content/messages'); ?>
<?php if($sf_params->get('toggle_link')): ?>
    <?php $link_title = ($perm->getStatus() == 'R') ? __('Grant private photos view permissions') : __('Revoke private photos view permissions'); ?>
    <script type="text/javascript" charset="utf-8">
        $('photo_perm_link').update('<?php echo $link_title; ?>');
    </script>
<?php endif; ?>