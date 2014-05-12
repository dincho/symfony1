<?php use_helper('Number') ?>
<table class="zebra reports">
    <thead>
        <tr>
            <th class="title">Flags and Suspensions</th>
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
    <?php if($flagsSuspensions): ?>
        <?php $object = $flagsSuspensions[0]; ?>
        <tr class="bold">
            <td>TOTAL</td>
            <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getTodayLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getToDate(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getPeriod(), 0, '.', ',') ?></td>
        </tr>
    <?php endif; ?>

    <?php if( $suspensions ): ?>
        <?php $object = $suspensions[0]; ?>
        <tr><td colspan="9" style="background-color: white">&nbsp;</td></tr>
        <tr><td colspan="9"></td></tr>
        <tr>
            <td><?php echo $object->getTitle()?></td>
            <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getTodayLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getToDate(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getPeriod(), 0, '.', ',') ?></td>
        </tr>
    <?php endif; ?>
</table>

<br />
<?php if( $mostActiveFlaggers ): ?>
<table class="zebra reports">
    <thead>
        <tr>
            <th class="title">Most Active Flaggers (Username)</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php foreach ($mostActiveFlaggers as $object): ?>
        <tr>
            <td><?php echo link_to($object->getUsername(), MemberPeer::getFrontendProfileUrl($object->getUsername()), array('popup' => true)) ?></td>
            <td><?php echo number_format($object->getTotal(), 0, '.', ',') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
