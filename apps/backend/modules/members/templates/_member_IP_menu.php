<?php echo " "; ?>
<?php echo ($member->isIpDublicated($ip))?link_to('DD', 'ipwatch/duplicates'):""; ?>
<?php echo " "; ?>
<?php echo ($member->isIpBlacklisted($ip))?link_to('BL', 'ipwatch/blacklisted'):link_to('BL+', 'ipwatch/addWatch', array('query_string' => 'ip='.ip2long($ip))); ?>
