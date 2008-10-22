<?php use_helper('Javascript') ?>
<div id="content_flags">
    <table class="zebra">
        <thead>
            <tr>
                <th>Sent Flags</th>
                <th># of members</th>
                <th>Username</th>
                <th>Profile ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Status</th>
                <th>Subscription</th>
                <th>Reviewed</th>
                <th>Review Date</th>
                <th></th>
            </tr>
        </thead>
        
    <?php foreach ($flags as $flag): ?>
        <?php $member = $flag->getFlagger(); ?>
        <tr rel="<?php echo url_for('flags/profileFlagger?id=' . $member->getId()); ?>" onmouseover="preview_click('<?php echo $member->getId();?>')" onmouseout="preview_clear();"">
            <td><?php echo $member->getCounter('SentFlags'); ?></td>
            <td><?php echo $flag->num_members; ?></td>
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
                <?php echo button_to_remote('Preview', array('url' => 'ajax/getMemberFlagsFlagger?id=' . $member->getId(), 'update' => 'preview'), 'id=preview_' . $member->getId()) ?>
            </td>
            <td class="profile"><?php echo link_to('Profile', '#') ?></td>
        </tr>
    <?php endforeach; ?>
    
    </table>
</div>
<div id="preview" class="scrollable small_scrollable">

</div>