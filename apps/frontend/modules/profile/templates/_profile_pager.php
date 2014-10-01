<?php if($pager && $sf_user->getAttribute('last_search_url') && $pager->haveToPaginate()): ?>
    <div class="prev">
        <?php if ($pager->getPage() != $pager->getFirstPage()): ?>
            <?php echo link_to(image_tag('prev.gif'),
                               '@profile?username=' . $pager->getPrevious()->getUsername() . '&page=' .$pager->getPreviousPage(), 'class=float-left'
            ); ?>
            <?php echo link_to(__('Previous'),
                               '@profile?username=' . $pager->getPrevious()->getUsername() . '&page=' .  $pager->getPreviousPage(),
                                array('class' => 'float-left', 'style' => 'padding: 0 20px;')
            ); ?>
        <?php else: ?>
            <span class="float-left"><?php echo image_tag('prev.gif'); ?></span>
            <span class="float-left" style="padding: 0 20px;"><?php echo __('Previous'); ?></span>
        <?php endif; ?>
    </div>

    <div class="next">

        <?php if ($pager->getPage() != $pager->getLastPage()): ?>
            <?php echo link_to(image_tag('next.gif'),
                               '@profile?username=' . $pager->getNext()->getUsername() . '&page=' .$pager->getNextPage(), 'class=float-right no-padding'
            ); ?>
            <?php echo link_to(__('Next'),
                               '@profile?username=' . $pager->getNext()->getUsername() . '&page=' .  $pager->getNextPage(),
                                array('class' => 'float-right', 'style' => 'padding: 0 20px;')
            ); ?>
        <?php else: ?>
            <span class="float-right no-padding"><?php echo image_tag('next.gif'); ?></span>
            <span class="float-right" style="padding: 0 20px;"><?php echo __('Next'); ?></span>
        <?php endif; ?>
    </div>

    <?php echo link_to(__('Return to Results'), $sf_user->getAttribute('last_search_url'), array('class' => 'sec_link')) ?>
<?php endif; ?>
