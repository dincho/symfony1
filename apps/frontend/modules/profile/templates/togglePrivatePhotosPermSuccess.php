<?php include_partial('content/messages'); ?>
<?php if ($sf_params->get('toggle_link')): ?>
    <?php $link_title = ($perm->getStatus() == 'R') ? __(
        'Grant private photos view permissions',
        array('%USERNAME%' => $profile->getUsername())
    ) : __(
        'Revoke private photos view permissions',
        array('%USERNAME%' => $profile->getUsername())
    ); ?>
    <script type="text/javascript" charset="utf-8">
        $('photo_perm_link')
            .update('<?php echo $link_title; ?>')
        <?php echo ($perm->getStatus() == 'R')? '.removeClassName("red");' : '.addClassName("red");';?>
    </script>
<?php endif; ?>
