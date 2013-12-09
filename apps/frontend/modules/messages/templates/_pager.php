<?php if ($pager->haveToPaginate()): ?>
    <div class="pager">
        <?php if($pager->getPage() != $pager->getFirstPage()) echo link_to(image_tag('prev.gif'), $route . '?page='.$pager->getPreviousPage() . @$query_string) ?>
        <span>
          <?php echo __('Page'); ?>
        </span>
        
        <?php if( $pager->getPage() > 3 && ($pager->getNbResults()/$pager->getMaxPerPage()) > 5 ): ?>
            <?php echo link_to('1...', $route . '?page=1' . @$query_string) ?>
        <?php endif; ?>
        
        <?php foreach ($pager->getLinks(5) as $page): ?>
            <?php echo link_to_unless($page == $pager->getPage(), $page, $route . '?page='.$page . @$query_string) ?>
        <?php endforeach; ?>
        <?php //echo 'pages: ' . ($pager->getNbResults()/$pager->getMaxPerPage()); ?>
        <?php if( $pager->getPage() < $pager->getLastPage()-2 && ($pager->getNbResults()/$pager->getMaxPerPage()) > 5 ): ?>
            <?php echo link_to('...'.$pager->getLastPage(), $route . '?page='.$pager->getLastPage() . @$query_string) ?>
        <?php endif; ?>
        
        <?php if($pager->getPage() != $pager->getLastPage()) echo link_to(image_tag('next.gif'), $route . '?page='.$pager->getNextPage() . @$query_string) ?>
        
        <?php if( $pager->getPage() == $pager->getLastPage() && $pager->getMaxRecordLimit() > 0 ): ?>
          <br />
          <?php echo link_to(__('See more matches'), 'subscription/index', array('class' => 'sec_link', )); ?>
          <?php echo link_to(image_tag('next.gif'), 'subscription/index'); ?>
        <?php endif; ?>

    </div>
<?php endif; ?>

