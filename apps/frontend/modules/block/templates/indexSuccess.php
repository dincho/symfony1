<?php echo __('To get new match results, change your %LINK_TO_SEARCH_CRITERIA%. <span style="font-size: 11px">(To unblock a member click "Unblock")</span>',  array('%LINK_TO_SEARCH_CRITERIA%' => link_to(__('Search Criteria'), 'dashboard/searchCriteria', array('class' => 'sec_link')))) ?>
<br /><br />
<table class="blocked_members">
<?php foreach ($blocks as $block): ?>
    <tr>
        <td><?php echo $block->getMemberRelatedByProfileId()->getUsername() ?></td>
        <td><span><?php echo Tools::truncate($block->getMemberRelatedByProfileId()->getEssayHeadline(), 40) ?></span></td>
        <td><span>ID: <?php echo $block->getProfileId() ?></span></td>
        <td><?php echo link_to_unless(!$block->getMemberRelatedByProfileId()->isActive(), __('View Profile'), '@profile?username=' . $block->getMemberRelatedByProfileId()->getUsername(), 'class=sec_link') ?></td>
        <td><?php echo link_to(__('Unblock'), 'block/remove?id=' . $block->getId(), 'class=sec_link') ?></td>
    </tr>
<?php endforeach; ?>
</table>