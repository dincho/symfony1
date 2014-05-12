<?php include_partial('content/messages'); ?>
<?php if($sf_params->get('toggle_link')): ?>
    <?php $link_title = ($perm->isDeleted()) ?
        __('%USERNAME% cannot see you. Let %USERNAME% see you.', array('%USERNAME%' => $member->getUsername())) :
        __('%USERNAME% can see you. Do not let %USERNAME% see you.', array('%USERNAME%' => $member->getUsername())); ?>
    <script type="text/javascript" charset="utf-8">
        $('privacy_link').update('<?php echo $link_title; ?>');
    </script>
<?php endif; ?>
