<div id="profile_pager">
    <?php if($sf_request->hasParameter('pager') && $sf_user->getAttribute('last_search_url') && $pager->hasResults()): ?>
        <div class="prev">
            <?php echo link_to_unless(is_null($pager->getPrevious()), image_tag('prev.gif'), '@profile?username=' . $pager->getPrevious(), 'class=float-left') ?>
            <?php echo link_to_unless(is_null($pager->getPrevious()), 'Previous', '@profile?username=' . $pager->getPrevious(), array('class' => 'float-left', 'style' => 'padding: 0 20px;')) ?>
        </div>
        
        <div class="next">
            <?php echo link_to_unless(is_null($pager->getNext()), image_tag('next.gif'), '@profile?username=' . $pager->getNext(), 'class=float-right no-padding') ?>
            <?php echo link_to_unless(is_null($pager->getNext()), 'Next', '@profile?username=' . $pager->getNext(), array('class' => 'float-right', 'style' => 'padding: 0 20px;')) ?>
        </div>
        
        <?php echo link_to(__('Return to Results'), $sf_user->getAttribute('last_search_url'), array('class' => 'sec_link')) ?>
    <?php endif; ?>
</div>
