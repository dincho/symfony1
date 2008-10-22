<?php if ($pager->haveToPaginate()): ?>
    <div class="pager">
        <?php if($pager->getPage() != $pager->getFirstPage()) echo link_to(image_tag('prev.gif'), $route . '?page='.$pager->getPreviousPage() . @$query_string) ?>
        <span>Page</span>
        <?php foreach ($pager->getLinks(5) as $page): ?>
            <?php echo link_to_unless($page == $pager->getPage(), $page, $route . '?page='.$page . @$query_string) ?>
        <?php endforeach; ?>
        <?php if($pager->getPage() != $pager->getLastPage()) echo link_to(image_tag('next.gif'), $route . '?page='.$pager->getNextPage() . @$query_string) ?>
    </div>
<?php endif; ?>
