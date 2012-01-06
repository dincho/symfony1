<label><?php echo $label;?></label>
<var>
    <?php if($ip): ?>
        <?php echo long2ip($ip) ?>
        <?php if( $isIpDublicatedIp ): ?>
            <?php echo link_to_remote('DD', array('url' => 'ajax/getUsersByIp?ip=' . $ip, 'update' => 'ip_duplicates')); ?>
        <?php endif; ?>
    
        <?php if( $isIpBlacklistedIp ): ?>
            <?php echo link_to('BL', 'ipwatch/blacklisted'); ?>
        <?php else: ?>
            <?php echo link_to('BL+', 'ipwatch/addWatch', array('query_string' => 'ip='.$ip)); ?>
        <?php endif; ?>
    <?php endif; ?>
</var><br />

<label>MM location</label>
<var><?php echo $ipLocation; ?></var><br />

