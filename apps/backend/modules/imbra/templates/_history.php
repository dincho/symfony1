<div id="bottom_menu">
  <span>History:</span>
  <ul>
    <?php foreach ($imbra->getAllVersions() as $imbra_history): ?>
    <li><?php echo link_to($imbra_history->getVersionCreatedAt('m/d/Y'), 'imbra/approve?member_id=' . $member->getId() .'&version=' . $imbra_history->getVersion()) ?>&nbsp;|&nbsp;</li>
    <?php endforeach; ?>
  </ul>
</div>