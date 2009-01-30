<?php use_helper('Number', 'xSortableTitle') ?>
<?php if($memberContacts): ?>
<table class="zebra reports">
    <thead>
        <tr>
            <th class="title">Member Contact</th>
            <th>Today</th>
            <th>Today LY</th>
            <th>MTD</th>
            <th>MTD LY</th>
            <th>YTD</th>
            <th>YTD LY</th>
            <th>To Date</th>
            <th style="width: auto;"><?php include_partial('period_filter', array('filters' => $filters)); ?></th>
        </tr>
    </thead>
        <?php $i=1;foreach ($memberContacts as $object): ?>
            <tr<?php if($i == 4) echo ' class="bold"'?>>
            <td><?php echo ($i!=4) ? $object->getTitle() : 'TOTAL' ?></td>
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
</table>
<br />
<?php endif; ?>

<table class="zebra reports">
    <thead>
        <tr>
            <th class="title">Login Activity</th>
            <th>Today</th>
            <th>Today LY</th>
            <th>30 days ago</th>
            <th>90 days ago</th>
        </tr>
    </thead>
        <tr class="bold">
            <td>Average Last Login Time</td>
            <td><?php echo $loginActivity->getToday() ?></td>
            <td><?php echo $loginActivity->getTodayLy() ?></td>
            <td><?php echo $loginActivity->get30da() ?></td>
            <td><?php echo $loginActivity->get90da() ?></td>
        </tr>
</table>

<br />
<table class="zebra reports" id="active_members">
    <thead>
        <tr>
            <th class="title">Most Active Members</th>
            <th><?php echo sortable_title('Unique Visits', 'MemberCounter::profile_views', $active_namespace, 'sort_active') ?></th>
            <th><?php echo sortable_title('Messages Sent', 'MemberCounter::sent_messages', $active_namespace, 'sort_active') ?></th>
            <th><?php echo sortable_title('Winks Sent', 'MemberCounter::sent_winks', $active_namespace, 'sort_active') ?></th>
            <th><?php echo sortable_title('Replies Sent', 'MemberCounter::reply_messages', $active_namespace, 'sort_active') ?></th>
            <th><?php echo sortable_title('Flags Given', 'MemberCounter::sent_flags', $active_namespace, 'sort_active') ?></th>
        </tr>
    </thead>
        <?php foreach ($mostActiveMembers as $member): ?>
        <tr>
            <?php $counter = $member->getMemberCounter() ?>
            <td><?php echo link_to($member->getUsername(), $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
            <td><?php echo number_format($counter->getProfileViews(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getSentMessages(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getSentWinks(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getReplyMessages(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getSentFlags(), 0, '.', ',') ?></td>
        </tr>
        <?php endforeach; ?>
</table>

<br /><br />
<table class="zebra reports" id="popular_members">
    <thead>
        <tr>
            <th class="title">Most Popular Members</th>
            <th><?php echo sortable_title('Profile Views', 'MemberCounter::made_profile_views', $popular_namespace, 'sort_popular') ?></th>
            <th><?php echo sortable_title('Messages Rec.', 'MemberCounter::received_messages', $popular_namespace, 'sort_popular') ?></th>
            <th><?php echo sortable_title('Winks Rec.', 'MemberCounter::received_winks', $popular_namespace, 'sort_popular') ?></th>
            <th><?php echo sortable_title('Replies Sent', 'MemberCounter::reply_messages', $popular_namespace, 'sort_popular') ?></th>
            <th><?php echo sortable_title('Flags Rec.', 'MemberCounter::total_flags', $popular_namespace, 'sort_popular') ?></th>
        </tr>
    </thead>
        <?php foreach ($mostPopularMembers as $member): ?>
        <tr>
            <?php $counter = $member->getMemberCounter() ?>
            <td><?php echo link_to($member->getUsername(), $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
            <td><?php echo number_format($counter->getMadeProfileViews(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getReceivedMessages(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getReceivedWinks(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getReplyMessages(), 0, '.', ',') ?></td>
            <td><?php echo number_format($counter->getTotalFlags(), 0, '.', ',') ?></td>
        </tr>
        <?php endforeach; ?>
</table>

<script type="text/javascript">
    var t1 = new ScrollableTable(document.getElementById('active_members'), 140);
    var t2 = new ScrollableTable(document.getElementById('popular_members'), 140);
</script>
