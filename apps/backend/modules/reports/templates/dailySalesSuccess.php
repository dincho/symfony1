<?php use_helper('Number') ?>
<table class="zebra reports">
    <thead>
        <tr>
            <th class="title">&nbsp;</th>
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
<?php if( $dailySalesByStatus ): ?>
    <?php $today = $todayLy = $mtd = $mtdLy = $ytd = $ytdLy = $toDate = $period = 0; ?>
    <?php foreach ($dailySalesByStatus as $key => $object): ?>
        <tr>
            <td><span class="float-right"><?php echo ($dailySalesLambdas[$key] > 0) ? '+' : '-' ?></span><?php echo $object->getTitle() ?></td>
            <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getTodayLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getToDate(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getPeriod(), 0, '.', ',') ?></td>
        </tr>
        <?php $today += $object->getToday() * $dailySalesLambdas[$key]; ?>
        <?php $todayLy += $object->getTodayLy() * $dailySalesLambdas[$key]; ?>
        <?php $mtd += $object->getMtd() * $dailySalesLambdas[$key]; ?>
        <?php $mtdLy += $object->getMtdLy() * $dailySalesLambdas[$key]; ?>
        <?php $ytd += $object->getYtd() * $dailySalesLambdas[$key]; ?>
        <?php $ytdLy += $object->getYtdLy() * $dailySalesLambdas[$key]; ?>
        <?php $toDate += $object->getToDate() * $dailySalesLambdas[$key]; ?>
        <?php $period += $object->getPeriod() * $dailySalesLambdas[$key]; ?>
    <?php endforeach; ?>
    <tr class="bold">
        <td><span class="float-right">=</span>TOTAL</td>
        <td><?php echo $today ?></td>
        <td><?php echo $todayLy ?></td>
        <td><?php echo $mtd ?></td>
        <td><?php echo $mtdLy ?></td>
        <td><?php echo $ytd ?></td>
        <td><?php echo $ytdLy ?></td>
        <td><?php echo $toDate ?></td>
        <td><?php echo $period ?></td>
    </tr>
<?php endif; ?>

    <tr><td colspan="9" style="background-color: white">&nbsp;</td></tr>
    <tr><td colspan="9"></td></tr>
    
<?php if( $dailySalesPaidMembers ): ?>
    <?php $paid_today = $paid_todayLy = $paid_mtd = $paid_mtdLy = $paid_ytd = $paid_ytdLy = $paid_toDate = $paid_period = 0; ?>
    <?php foreach ($dailySalesPaidMembers as $key => $object): ?>
        <tr>
            <td><span class="float-right"><?php echo ($dailySalesPaidMembersLambdas[$key] > 0) ? '+' : '-' ?></span><?php echo $object->getTitle() ?></td>
            <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getTodayLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getMtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtd(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getYtdLy(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getToDate(), 0, '.', ',') ?></td>
            <td><?php echo number_format($object->getPeriod(), 0, '.', ',') ?></td>
        </tr>
        <?php $paid_today += $object->getToday() * $dailySalesPaidMembersLambdas[$key]; ?>
        <?php $paid_todayLy += $object->getTodayLy() * $dailySalesPaidMembersLambdas[$key]; ?>
        <?php $paid_mtd += $object->getMtd() * $dailySalesPaidMembersLambdas[$key]; ?>
        <?php $paid_mtdLy += $object->getMtdLy() * $dailySalesPaidMembersLambdas[$key]; ?>
        <?php $paid_ytd += $object->getYtd() * $dailySalesPaidMembersLambdas[$key]; ?>
        <?php $paid_ytdLy += $object->getYtdLy() * $dailySalesPaidMembersLambdas[$key]; ?>
        <?php $paid_toDate += $object->getToDate() * $dailySalesPaidMembersLambdas[$key]; ?>
        <?php $paid_period += $object->getPeriod() * $dailySalesPaidMembersLambdas[$key]; ?>
    <?php endforeach; ?>
    <tr class="bold">
        <td><span class="float-right">=</span>TOTAL</td>
        <td><?php echo $paid_today ?></td>
        <td><?php echo $paid_todayLy ?></td>
        <td><?php echo $paid_mtd ?></td>
        <td><?php echo $paid_mtdLy ?></td>
        <td><?php echo $paid_ytd ?></td>
        <td><?php echo $paid_ytdLy ?></td>
        <td><?php echo $paid_toDate ?></td>
        <td><?php echo $paid_period ?></td>
    </tr>
<?php endif; ?>

    <tr><td colspan="9" style="background-color: white">&nbsp;</td></tr>
    
    <tr>
        <td>Full Memb. % (II/ I)</td>
        <td><?php echo ($today == 0) ? 0 : round($paid_today/$today*100) ?></td>
        <td><?php echo ($todayLy == 0) ? 0 : round($paid_todayLy/$todayLy*100) ?></td>
        <td><?php echo ($mtd == 0) ? 0 : round($paid_mtd/$mtd*100) ?></td>
        <td><?php echo ($mtdLy == 0) ? 0 : round($paid_mtdLy/$mtdLy*100) ?></td>
        <td><?php echo ($ytd == 0) ? 0 : round($paid_ytd/$ytd*100) ?></td>
        <td><?php echo ($ytdLy == 0) ? 0 : round($paid_ytdLy/$ytdLy*100) ?></td>
        <td><?php echo ($toDate == 0) ? 0 : round($paid_toDate/$toDate*100) ?></td>
        <td><?php echo ($period == 0) ? 0 : round($paid_period/$period*100) ?></td>
    </tr>
    <tr>
        <td>Full Memb. Deletion % (14/II)</td>
        <td><?php echo ($paid_today == 0) ? 0 : round($dailySalesPaidMembers[5]->getToday()/$paid_today*100) ?></td>
        <td><?php echo ($paid_todayLy == 0) ? 0 : round($dailySalesPaidMembers[5]->getTodayLy()/$paid_todayLy*100) ?></td>
        <td><?php echo ($paid_mtd == 0) ? 0 : round($dailySalesPaidMembers[5]->getMtd()/$paid_mtd*100) ?></td>
        <td><?php echo ($paid_mtdLy == 0) ? 0 : round($dailySalesPaidMembers[5]->getMtdLy()/$paid_mtdLy*100) ?></td>
        <td><?php echo ($paid_ytd == 0) ? 0 : round($dailySalesPaidMembers[5]->getYtd()/$paid_ytd*100) ?></td>
        <td><?php echo ($paid_ytdLy == 0) ? 0 : round($dailySalesPaidMembers[5]->getYtdLy()/$paid_ytdLy*100) ?></td>
        <td><?php echo ($paid_toDate == 0) ? 0 : round($dailySalesPaidMembers[5]->getToDate()/$paid_toDate*100) ?></td>
        <td><?php echo ($paid_period == 0) ? 0 : round($dailySalesPaidMembers[5]->getPeriod()/$paid_period*100) ?></td>
    </tr>
    <tr>
        <td>Deletion % (3/ I)</td>
        <td><?php echo ($today == 0) ? 0 : round($dailySalesByStatus[2]->getToday()/$today*100) ?></td>
        <td><?php echo ($todayLy == 0) ? 0 : round($dailySalesByStatus[2]->getTodayLy()/$todayLy*100) ?></td>
        <td><?php echo ($mtd == 0) ? 0 : round($dailySalesByStatus[2]->getMtd()/$mtd*100) ?></td>
        <td><?php echo ($mtdLy == 0) ? 0 : round($dailySalesByStatus[2]->getMtdLy()/$mtdLy*100) ?></td>
        <td><?php echo ($ytd == 0) ? 0 : round($dailySalesByStatus[2]->getYtd()/$ytd*100) ?></td>
        <td><?php echo ($ytdLy == 0) ? 0 : round($dailySalesByStatus[2]->getYtdLy()/$ytdLy*100) ?></td>
        <td><?php echo ($toDate == 0) ? 0 : round($dailySalesByStatus[2]->getToDate()/$toDate*100) ?></td>
        <td><?php echo ($period == 0) ? 0 : round($dailySalesByStatus[2]->getPeriod()/$period*100) ?></td>
    </tr>
    <tr>
        <td>Full Memb. Renewals % (11/ II)</td>
        <td><?php echo ($paid_today == 0) ? 0 : round($dailySalesPaidMembers[2]->getToday()/$paid_today*100) ?></td>
        <td><?php echo ($paid_todayLy == 0) ? 0 : round($dailySalesPaidMembers[2]->getTodayLy()/$paid_todayLy*100) ?></td>
        <td><?php echo ($paid_mtd == 0) ? 0 : round($dailySalesPaidMembers[2]->getMtd()/$paid_mtd*100) ?></td>
        <td><?php echo ($paid_mtdLy == 0) ? 0 : round($dailySalesPaidMembers[2]->getMtdLy()/$paid_mtdLy*100) ?></td>
        <td><?php echo ($paid_ytd == 0) ? 0 : round($dailySalesPaidMembers[2]->getYtd()/$paid_ytd*100) ?></td>
        <td><?php echo ($paid_ytdLy == 0) ? 0 : round($dailySalesPaidMembers[2]->getYtdLy()/$paid_ytdLy*100) ?></td>
        <td><?php echo ($paid_toDate == 0) ? 0 : round($dailySalesPaidMembers[2]->getToDate()/$paid_toDate*100) ?></td>
        <td><?php echo ($paid_period == 0) ? 0 : round($dailySalesPaidMembers[2]->getPeriod()/$paid_period*100) ?></td>
    </tr>
</table>





