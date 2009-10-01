<?php echo __('To get new match results, change your <a href="%URL_FOR_SEARCH_CRITERIA%" class="sec_link">Search Criteria</a>. <span style="font-size: 11px">(To unblock a member click "Unblock")</span>') ?>
<br /><br />
<?php if( count($blocks) > 0 ): ?>
  <table class="blocked_members">
  <?php foreach ($blocks as $block): ?>
      <tr>
          <td><?php echo $block->getMemberRelatedByProfileId()->getUsername() ?></td>
          <td><span><?php echo Tools::truncate($block->getMemberRelatedByProfileId()->getEssayHeadline(), 40) ?></span></td>
          <td><span>ID: <?php echo $block->getProfileId() ?></span></td>
          <td><?php echo link_to(__('View Profile'), '@profile?bc=blocked&username=' . $block->getMemberRelatedByProfileId()->getUsername(), 'class=sec_link') ?></td>
          <td><?php echo link_to(__('Unblock'), 'block/remove?id=' . $block->getId(), 'class=sec_link') ?></td>
      </tr>
  <?php endforeach; ?>
  </table>
<?php endif; ?>
<?php slot('footer_menu') ?>
    <?php include_partial('content/footer_menu') ?>
<?php end_slot(); ?>