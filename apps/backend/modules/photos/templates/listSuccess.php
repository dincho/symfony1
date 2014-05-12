<?php use_helper('Object', 'Window', 'hoverImage') ?>
<div id="photos">

    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/list')); ?><br />
    View as:
    <?php if ($filters['is_list'] == 1 ):?>

      <?php include_partial('photos/list_view', array('pager' => $pager, 'query_string' => $query_string)); ?>

    <?php else: ?>

      <?php include_partial('photos/grid_view', array('pager' => $pager, 'query_string' => $query_string, 'grid_per_row' => $grid_per_row)); ?>

    <?php endif;?>

    <?php include_partial('system/pager', array('pager' => $pager, 'route' => 'photos/list')); ?>
</div>
