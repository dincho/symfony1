<?php include_partial('content/messages'); ?>
<?php if($sf_params->get('toggle_link')): ?>
    <?php $link_title = ($perm->isDeleted()) ? __('She (he) can not see you. Let her') : __('She (he) can see you. Do not let her'); ?>
    <script type="text/javascript" charset="utf-8">
        $('privacy_link').update('<?php echo $link_title; ?>');
    </script>
<?php endif; ?>