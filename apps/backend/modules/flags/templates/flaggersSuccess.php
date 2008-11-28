<?php use_helper('Javascript') ?>
<table class="zebra">
    <thead>
        <tr>
            <th>Sent Flags</th>
            <th># of members</th>
            <th>Username</th>
            <th>Profile ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Subscription</th>
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
        <td class="profile"><?php echo link_to('Profile', '#') ?></td>
    </tr>
<?php endforeach; ?>

</table>

<?php include_partial('system/pager', array('pager' => $pager, 'route' => 'flags/list')); ?>
<div id="preview" class="scrollable small_scrollable"></div>