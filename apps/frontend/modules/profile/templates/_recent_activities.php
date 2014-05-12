<?php $recent_activities = $member->getLastActivityWith($sf_user->getId()); ?>

<table class="conversations_messages" cellspacing="0" cellpadding="0">
    <tr>
        <th colspan="4"><?php echo __('Your Recent Activities with %username%', array('%username%' => $member->getUsername()))?></th>
    </tr>
    <?php if( isset($recent_activities) && count($recent_activities) > 0 ): ?>

        <script type="text/javascript">
            Event.observe(window, 'load', function () {
                var RA_balloon = new Balloon;
                BalloonConfig(RA_balloon, 'GBubble');
                RA_balloon.fontSize = '12px';
            });
         </script>

        <?php foreach ($recent_activities as $activity): ?>
            <?php $user = ($activity->getMemberId() == $member->getId() ) ? $member->getUsername() : __('You'); ?>
            <tr>
                <?php if( ($activity->getActivity() == 'mailed') && !$activity->getActionId() ): ?>
                    <td class="color-gray"><?php echo $user ?></td>
                    <td class="color-gray"><?php echo __($activity->getActivity()); ?></td>
                    <td class="color-gray"><?php echo __('deleted'); ?></td>
                <?php else: ?>
                    <td><?php echo link_to($user, url_for_activity($activity), array('class' => 'sec_link')); ?></td>
                    <td><?php echo link_to(__($activity->getActivity()), url_for_activity($activity), array('class' => 'sec_link')); ?></td>
                    <td><?php echo format_date_pr($activity->getDtime(), null, 'dd-MMM-yyyy', $sf_user->getProfile()->getTimezone()) ?></td>
                <?php endif; ?>
                <td><?php echo link_for_extra_activity_field($activity, $member); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="3" class="color-gray"><?php echo __('You don\'t have any activities with %username% yet.', array('%username%' => $member->getUsername())) ?></td>
    </tr>
    <?php endif; ?>
</table>
