<?php use_helper('Number', 'xSortableTitle') ?>
<table class="zebra reports">
    <thead>
        <tr>
            <th class="title">Email</th>
            <th>Today</th>
            <th>Yesterday</th>
            <th>Two days ago</th>
            <th>All time</th>
            <th>All days</th>
            <th>Average/day</th>
            <th></th>
        </tr>
    </thead>
    <?php foreach ($outgoingMails as $key => $object): ?>
        <tr>
            <td><?php echo $object->getEmail() ?></td>
            <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYesterday(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getTwoDaysAgo(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getAllTime(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getAllDays(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getAverageDay(), 0, '.', ',') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br />
