<?php use_helper('Javascript', 'xSortableTitle') ?>
<?php include_partial('members/search_filter', array('filters' => $filters, 'extra_vars' => array('filters[confirmed]' => $filters['confirmed']))); ?>

    <table class="zebra">
        <thead>
            <tr>
                <th><?php echo sortable_title('Suspended', 'Member::last_status_change', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Username', 'Member::username', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Profile ID', 'Member::id', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Last Name', 'Member::last_name', $sort_namespace) ?></th>
                <th><?php echo sortable_title('First Name', 'Member::first_name', $sort_namespace) ?></th>
                <th><?php echo sortable_title('Subscription', 'Subscription::title', $sort_namespace) ?></th>
                <th colspan="2"></th>
            </tr>
        </thead>

    <?php foreach ($pager->getResults() as $member): ?>
        <?php //$member = $flag->getMember(); ?>
        <tr rel="<?php echo url_for('flags/profileFlagged?id=' . $member->getId()); ?>" onmouseover="preview_click('<?php echo $member->getId();?>')" onmouseout="preview_clear();"">
            <td><?php echo $member->getLastStatusChange('m/d/Y'); ?></td>
            <td><?php echo $member->getUsername(); ?></td>
            <td><?php echo $member->getId(); ?></td>
            <td><?php echo $member->getLastName(); ?></td>
            <td><?php echo $member->getFirstName(); ?></td>
            <td><?php echo $member->getSubscription(); ?></td>
            <td class="preview_button">
                <?php echo button_to_remote('Preview', array('url' => 'ajax/getMemberFlagsFlagged?id=' . $member->getId() .'&history=1', 'update' => 'preview'), 'id=preview_' . $member->getId()) ?>
            </td>
            <td class="profile"><?php echo link_to('Profile', $member->getFrontendProfileUrl(), array('popup' => true)) ?></td>
        </tr>
    <?php endforeach; ?>

    </table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'flags/suspended')); ?>
<div id="preview">

</div>
