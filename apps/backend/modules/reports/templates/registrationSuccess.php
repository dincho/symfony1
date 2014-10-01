<?php use_helper('Number') ?>
<?php if($objects): ?>
<table class="zebra reports">
    <thead>
        <tr>
            <th></th>
            <th>Today</th>
            <th>Today LY</th>
            <th>MTD</th>
            <th>MTD LY</th>
            <th>YTD</th>
            <th>YTD LY</th>
            <th>To Date</th>
            <th><?php include_partial('period_filter', array('filters' => $filters)); ?></th>
        </tr>
    </thead>
    <?php foreach ($objects as $key => $object): ?>
        <tr>
            <td><?php echo $object->getTitle() ?></td>
            <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getTodayLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getToDate(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getPeriod(), 0, '.', ',') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php else: ?>
    No members yet
<?php endif; ?>
