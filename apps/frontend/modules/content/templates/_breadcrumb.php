<div id="header_text">
    <span>
    <?php echo __('You are here: ')?>
    <?php $BC = $sf_user->getBC(); ?>
    <?php $stack = $BC->getStack(); $cnt = count($stack)-1; //do not add link to last element ?>
    
    <?php for( $i=0; $i<$cnt; $i++ ): ?>
      <?php $name = ( !isset($stack[$i]['tr']) || $stack[$i]['tr'] ) ? __($BC->getElementName($i)) : $BC->getElementName($i); ?>
      <?php echo (( isset($stack[$i]['uri']) ) ? link_to($name, $stack[$i]['uri']) : $name). $BC->getDelimiter(); ?>
    <?php endfor; ?>

    <?php if( $BC->getCustomLastItem() ): ?>
        <?php echo $BC->getCustomLastItem(); //this setter takes already internationalized values since the output is not internationalized because the need of specific parameters ?>
    <?php else: ?>
        <?php echo $BC->getLastName(); //add last element manual, just text not a link ?>
    <?php endif; ?>
    </span>
    <div id="header_title">
        <?php echo image_tag('header_text/left.gif', 'class=float-left') ?>
        <?php echo image_tag('header_text/right.gif', 'class=float-right') ?>
        <h2 style="float:none;"><?php echo $sf_user->getBC()->getLastName() ?></h2>
        <?php if( isset($header_current_step) && isset($header_steps)): ?>
            <span><?php echo __('Step %CURRENT_STEP% of %STEPS%', array('%CURRENT_STEP%' => $header_current_step, '%STEPS%' => $header_steps)); ?></span>
        <?php endif; ?>
    </div>
</div>