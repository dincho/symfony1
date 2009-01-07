<?php use_helper('Javascript', 'xSortableTitle') ?>
<?php include_partial('members/search_filter', array('filters' => $filters)); ?>

<table class="zebra">
    <thead>
        <tr>
            <th><?php echo sortable_title('Sent Flags', 'MemberCounter::sent_flags', $sort_namespace) ?></th>
            <th># of members</th>
            <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
            <th><?php echo sortable_title('Profile ID', 'Member::id', $sort_namespace) ?></th>
            <th><?php echo sortable_title('Last Name', 'Member::last_name', $sort_namespace) ?></th>
            <th><?php echo sortable_title('First Name', 'Member::first_name', $sort_namespace) ?></th>
            <th><?php echo sortable_title('Subscription', 'Subscription::title', $sort_namespace) ?></th>            
            <th></th>
        </tr>
    </thead>
    
<?php foreach ($pager->getResults() as $member): ?>
    <tr rel="<?php echo url_for('flags/profileFlagger?id=' . $member->getId()); ?>" onmouseover="preview_click('<?php echo $member->getId();?>')" onmouseout="preview_clear();"">
        <td><?php echo $member->getCounter('SentFlags'); ?></td>
        <td><?php echo $member->custom1; ?></td>
        <td><?php echo $member->getUsername(); ?></td>
        <td><?php echo $member->getId(); ?></td>
        <td><?php echo $member->getLastName(); ?></td>
        <td><?php echo $member->getFirstName(); ?></td>
        <td><?php echo $member->getSubscription(); ?></td>
        <td class="preview_button">
            <?php echo button_to_remote('Preview', array('url' => 'ajax/getMemberFlagsFlagger?id=' . $member->getId(), 'update' => 'preview'), 'id=preview_' . $member->getId()) ?>
        </td>
        <td class="profile"><?php echo link_to('Profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
    </tr>
<?php endforeach; ?>

</table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'flags/flaggers')); ?>
<div id="preview" class="scrollable small_scrollable"></div>