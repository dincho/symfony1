<label><?php echo $label;?></label>
<var><?php echo $ip ?>
  <?php echo " "; ?>
  <?php echo ($isIpDublicatedIp)?link_to('DD', 'ipwatch/duplicates'):""; ?>
  <?php echo " "; ?>
  <?php echo ($isIpBlacklistedIp)?link_to('BL', 'ipwatch/blacklisted'):link_to('BL+', 'ipwatch/addWatch', array('query_string' => 'ip='.$ip)); ?>
</var>
<br />
<label>MM location</label>
<var><?php echo $ipLocation; ?></var>
<br />

