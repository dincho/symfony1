<div class="legend">IMBRA Application (<?php echo $imbra->getCreatedAt('m/d/Y') ?>) - <?php echo $imbra->getImbraStatus() ?></div>
<?php include_partial('imbra/edit', array('member' => $member, 'imbra' => $imbra)); ?>
<div id="bottom_menu">
  <span class="bottom_menu_title">History:</span>
  <ul>
    <?php foreach ($imbras as $imbra_history): ?>
    <li><?php echo link_to_unless($imbra_history->getId() == $sf_request->getParameter('id'), $imbra_history->getCreatedAt('m/d/Y'), 'imbra/edit?member_id=' . $member->getId() .'&id=' . $imbra_history->getId() . '&filter=filter&filters[imbra_status_id]='.$imbra_history->getImbraStatusId()) ?>&nbsp;|&nbsp;</li>
    <?php endforeach; ?>
  </ul>
</div>