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
        <?php $i=1;foreach ($flagsSuspensions as $object): ?>
            <tr<?php if($i == 5) echo ' class="bold"'?>>
                <td><?php echo ( $i!=5 ) ? '# of ' . $object->getTitle() . ' flags': 'TOTAL' ?></td>
                <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->getTodayLy(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->getMtd(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->getMtdLy(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->getYtd(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->getYtdLy(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->getToDate(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->getPeriod(), 0, '.', ',') ?></td>
            </tr>
        <?php $i++;endforeach; ?>
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
            <th>Inappropriate</th>
            <th>Spam</th>
            <th>Scam</th>
            <th>Other</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php foreach ($mostActiveFlaggers as $object): ?>
        <tr>
            <td><?php echo link_to($object->getUsername(), MemberPeer::getFrontendProfileUrl($object->getUsername()), array('popup' => true)) ?></td>
            <td><?php echo number_format($object->getInappropriate(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getSpam(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getScam(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getOther(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getTotal(), 0, '.', ',') ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>