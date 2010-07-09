<?php use_helper('Number', 'xSortableTitle') ?>
<table class="zebra reports">
    <thead>
        <tr>
            <th class="title">Filter</th>
            <th>Filter</th>
            <th style="width: auto;"><?php include_partial('period_filter', array('filters' => $filters)); ?></th>
        </tr>
    </thead>
</table>
<br />
