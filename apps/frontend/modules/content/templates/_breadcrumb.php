<div id="header_text">
    <span>
    <?php echo __('You are here: ')?>
    <?php $sf_user->getBC()->draw(); ?>
    </span>
    <div id="header_title">
        <?php echo image_tag('header_text/left.gif', 'class=float-left') ?>
        <?php echo image_tag('header_text/right.gif', 'class=float-right') ?>
        <h2><?php echo ( !isset($header_title) ) ? ucfirst(ereg_replace('([A-Z])', ' \\1', $sf_user->getBC()->getLastName())) : $header_title ?></h2>
        <?php if( isset($header_span) ): ?>
            <span><?php echo $header_span; ?></span>
        <?php endif; ?>
    </div>
</div>