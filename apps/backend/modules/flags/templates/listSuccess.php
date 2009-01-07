<?php use_helper('Javascript', 'xSortableTitle') ?>
<?php include_partial('members/search_filter', array('filters' => $filters, 'extra_vars' => array('filters[history]' => $filters['history']))); ?>

    <table class="zebra">
        <thead>
            <tr>
                <th><?php echo sortable_title('Flagged', 'Member::last_flagged', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Flags', 'MemberCounter::current_flags', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Profile ID', 'Member::id', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Last Name', 'Member::last_name', $sort_namespace) ?></th>
                <th><?php echo sortable_title('First Name', 'Member::first_name', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Status', 'MemberStatus::title', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Subscription', 'Subscription::title', $sort_namespace) ?></th>            
                <th><?php echo sortable_title('Reviewed', 'User::username', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Review Date', 'Member::reviewed_at', $sort_namespace) ?></th>
                <th></th>
            </tr>
        </thead>
        
    <?php foreach ($pager->getResults() as $member): ?>
        <?php //$member = $flag->getMember(); ?>
        <tr rel="<?php echo url_for('flags/profileFlagged?id=' . $member->getId()); ?>" onmouseover="preview_click('<?php echo $member->getId();?>')" onmouseout="preview_clear();"">
            <td><?php echo $member->getLastFlagged('m/d/Y'); ?></td>
            <?php if($is_history): ?>
                <td><?php echo $member->getCounter('TotalFlags') - $member->getCounter('CurrentFlags'); ?></td>
            <?php else: ?>
                <td><?php echo $member->getCounter('CurrentFlags'); ?></td>
            <?php endif; ?>
            <td><?php echo $member->getUsername(); ?></td>
            <td><?php echo $member->getId(); ?></td>
            <td><?php echo $member->getLastName(); ?></td>
            <td><?php echo $member->getFirstName(); ?></td>
            <td><?php echo $member->getMemberStatus(); ?></td>
            <td><?php echo $member->getSubscription(); ?></td>
            <?php if( $member->getReviewedById() ): ?>
                <td><?php echo $member->getReviewedBy()->getUsername(); ?></td>
                <td><?php echo $member->getReviewedAt('m/d/Y'); ?></td>
            <?php else: ?>
                <td></td>
                <td></td>
            <?php endif; ?>
            <td class="preview_button">
                <?php echo button_to_remote('Preview', array('url' => 'ajax/getMemberFlagsFlagged?id=' . $member->getId() .'&history=' . $filters['history'], 'update' => 'preview'), 'id=preview_' . $member->getId()) ?>
            </td>
            <td class="profile"><?php echo link_to('Profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
        </tr>
    <?php endforeach; ?>
    
    </table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'flags/list')); ?>
<div id="preview"></div>