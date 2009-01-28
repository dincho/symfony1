<?php
class tools {
/**
* returns true if the user is blocked, false otherwise
*/
    public static function check_ip_block()
    {
	// 1 -> check email
	$c = new Criteria;
	$c->add(IpblockPeer::ITEM_TYPE, 1);
	$c->add(IpblockPeer::ITEM, sfContext::getInstance()->getUser()->getAttribute('email'));
	$b = IpblockPeer::doSelectOne($c);
	if ($b)
	{
	    return true;
	}

	// 0 -> check domain
	$c = new Criteria;
	$c->add(IpblockPeer::ITEM_TYPE, 0);
	$blocks = IpblockPeer::doSelect($c);

	$domain = tools::ip2host($_SERVER['REMOTE_ADDR']);
	if (!empty($blocks) && $domain)
	{
	    foreach ($blocks as $b)
	    {
		if ($b->getItem() == $domain || eregi('[a-zA-Z0-9]+\.'.$b->getItem(), $domain))
		{
		    return true;
		}
	    }
	}

	//2 -> check ip match
	$c = new Criteria;
	$c->add(IpblockPeer::ITEM_TYPE, 2);
	$c->add(IpblockPeer::ITEM, $_SERVER['REMOTE_ADDR']);
	$b = IpblockPeer::doSelectOne($c);
	if ($b)
	{
	    return true;
	}


	// 0 -> check network masks
	$c = new Criteria;
	$c->add(IpblockPeer::ITEM_TYPE, 3);
	$blocks = IpblockPeer::doSelect($c);

	$ip= $_SERVER['REMOTE_ADDR'];
	if (!empty($blocks) && $domain)
	{
	    foreach ($blocks as $b)
	    {
		//calc start and end ips for this subnet
		$netmask = $b->getNetmask();
		$ipaddr  = $b->getItem();

		$ipaddr_num = ip2long($ipaddr);
		$netmask_num = ip2long(tools::short_mask_to_long($netmask));

		$addrs = array();
		$addrs['NETWORK'] = $ipaddr_num & $netmask_num;
		$addrs['BROADCAST'] = $ipaddr_num | (~ $netmask_num);

		//$addrs['NETWORK'] = long2ip($ipaddr_num & $netmask_num);
		//$addrs['BROADCAST'] = long2ip($ipaddr_num | (~ $netmask_num));
//		$addrs['NETMASK'] = long2ip($netmask_num);


		if ($ip >= $addrs['NETWORK']  && $ip <= $addrs['BROADCAST'])
		{
		    return true;
		}
	    }
	}



	return false;
    }

    public static function cdrtobin($cdrin)
    {
	return str_pad(str_pad("", $cdrin, "1"), 32, "0");
    }

    public static function bintodq($binin)
    {
	$binin = explode(".", chunk_split($binin, 8, "."));
	for ($i = 0; $i < 4; $i ++)
	{
	    $dq[$i] = bindec($binin[$i]);
	}
	return implode(".", $dq);
    }


    public static function short_mask_to_long($m)
    {
	return tools::bintodq(tools::cdrtobin($m)); 
    }

    public static function ip2host($ip)
    {
	return gethostbyaddr($ip);
    }
}

