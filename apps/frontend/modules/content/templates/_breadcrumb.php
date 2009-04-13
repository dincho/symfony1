<div id="header_text">
    <span>
    <?php echo __('You are here: ')?>
    
    <?php $sf_user->getBC()->draw(); ?>
		
    </span>
    <div id="header_title">
        <?php echo image_tag('header_text/left.gif', 'class=float-left') ?>
        <?php echo image_tag('header_text/right.gif', 'class=float-right') ?>
        <h2 style="float:none;"><?php echo __($sf_user->getBC()->getLastName()) ?></h2>
        <?php if( isset($header_current_step) && isset($header_steps)): ?>
            <span><?php echo __('Step %CURRENT_STEP% of %STEPS%', array('%CURRENT_STEP%' => $header_current_step, '%STEPS%' => $header_steps)); ?></span>
        <?php endif; ?>
    </div>
</div>