<?php echo __('To get new match results, change your %LINK_TO_SEARCH_CRITERIA%. <span>(To unblock a member click "Unblock")</span>',  array('%LINK_TO_SEARCH_CRITERIA%' => link_to(__('Search Criteria'), 'dashboard/searchCriteria'))) ?>
<br /><br />
<table class="blocked_members">
<?php foreach ($blocks as $block): ?>
    <tr>
		<td><?php echo $block->getMemberRelatedByProfileId()->getUsername() ?></td>
		<td class="color-gray"><?php echo Tools::truncate($block->getMemberRelatedByProfileId()->getEssayHeadline(), 40) ?></td>
		<td class="color-gray">ID: <?php echo $block->getProfileId() ?></td>
		<td><?php echo link_to(__('View Profile'), '@profile?username=' . $block->getMemberRelatedByProfileId()->getUsername(), 'class=sec_link') ?></td>
		<td><?php echo link_to(__('Unblock'), 'block/remove?id=' . $block->getId(), 'class=sec_link') ?></td>
	</tr>
<?php endforeach; ?>
</table>