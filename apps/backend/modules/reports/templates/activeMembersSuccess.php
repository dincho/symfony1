<?php use_helper('Number') ?>
<table class="zebra reports">
        <tr>
            <th>Member Types</th>
            <th>Today</th>
            <th>7 days Ago</th>
            <th>30 days Ago</th>
            <th>3 months Ago</th>
            <th>6 months Ago</th>
            <th>1 Year Ago</th>
            <th>2 Years Ago</th>
            <th>3 Years Ago</th>
        </tr>
    <?php foreach($subscriptions as $subscription): ?>
        <?php if($objects = Reports::getActiveMembersBySubscription($subscription->getId())): ?>
            <?php $cnt = count($objects); ?>
            <?php $i=1;foreach ($objects as $object): ?>
                <tr>
                    <td>
                        <?php echo substr($subscription->getTitle(), 0, 4) . '&nbsp;' . (($i!=$cnt) ? $object->getTitle() : '(men and women)') ?>
                    </td>
                    <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
                    <td><?php echo number_format($object->get7da(), 0, '.', ',') ?></td>
                    <td><?php echo number_format($object->get30da(), 0, '.', ',') ?></td>
                    <td><?php echo number_format($object->get3ma(), 0, '.', ',') ?></td>
                    <td><?php echo number_format($object->get6ma(), 0, '.', ',') ?></td>
                    <td><?php echo number_format($object->get1ya(), 0, '.', ',') ?></td>
                    <td><?php echo number_format($object->get2ya(), 0, '.', ',') ?></td>
                    <td><?php echo number_format($object->get3ya(), 0, '.', ',') ?></td>
                </tr>
            <?php $i++;endforeach; ?>
            <tr><td colspan="9" style="background-color: white">&nbsp;</td></tr>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if( $objects = Reports::getActiveMembersByLocation()): ?>
        <?php foreach ($objects as $object): ?>
            <tr>
                <td><?php echo $object->getTitle()?></td>
                <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get7da(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get30da(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get3ma(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get6ma(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get1ya(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get2ya(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get3ya(), 0, '.', ',') ?></td>
            </tr>
        <?php endforeach; ?>
        <tr><td colspan="9" style="background-color: white">&nbsp;</td></tr>
    <?php endif; ?>
    <?php if($objects = Reports::getActiveMembersTotal()): ?>
        <?php $cnt = count($objects); ?>
        <?php $i=1;foreach ($objects as $object): ?>
            <tr<?php if($i == $cnt) echo ' class="bold"'?>>
                <td>
                    <?php echo ($i!=$cnt) ? $object->getTitle() : 'TOTAL' ?>
                </td>
                <td><?php echo number_format($object->getToday(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get7da(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get30da(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get3ma(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get6ma(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get1ya(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get2ya(), 0, '.', ',') ?></td>
                <td><?php echo number_format($object->get3ya(), 0, '.', ',') ?></td>
            </tr>
        <?php $i++;endforeach; ?>
        <tr><td colspan="9" style="background-color: white">&nbsp;</td></tr>
    <?php endif; ?>
</table>
