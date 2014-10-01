<?php

/**
 * Subclass for performing query and update operations on the 'ipblock' table.
 *
 *
 *
 * @package lib.model
 */
class IpblockPeer extends BaseIpblockPeer
{
    /**
     * returns true if the user is blocked, false otherwise
     */
    public static function hasBlockFor($email = null, $ip = null)
    {
        // 1 -> check email
        $c = new Criteria();
        $c->add(IpblockPeer::ITEM_TYPE, 1);
        $c->add(IpblockPeer::ITEM, $email);
        $b = IpblockPeer::doSelectOne($c);
        if($b) return true;

        // 0 -> check domain
        $c = new Criteria();
        $c->add(IpblockPeer::ITEM_TYPE, 0);
        $blocks = IpblockPeer::doSelect($c);

        $domain = Tools::ip2host($ip);
        if (!empty($blocks) && $domain) {
            foreach ($blocks as $b) {
                if ($b->getItem() == $domain || eregi('[a-zA-Z0-9]+\.' . $b->getItem(), $domain)) {
                    return true;
                }
            }
        }

        //2 -> check ip match
        $c = new Criteria();
        $c->add(IpblockPeer::ITEM_TYPE, 2);
        $c->add(IpblockPeer::ITEM, $ip);
        $b = IpblockPeer::doSelectOne($c);
        if($b) return true;

        // 0 -> check network masks
        $c = new Criteria();
        $c->add(IpblockPeer::ITEM_TYPE, 3);
        $blocks = IpblockPeer::doSelect($c);

        if (!empty($blocks) && $domain) {
            foreach ($blocks as $b) {
                //calc start and end ips for this subnet
                $netmask = $b->getNetmask();
                $ipaddr = $b->getItem();

                $ipaddr_num = ip2long($ipaddr);
                $netmask_num = ip2long(Tools::short_mask_to_long($netmask));

                $addrs = array();
                $addrs ['NETWORK'] = $ipaddr_num & $netmask_num;
                $addrs ['BROADCAST'] = $ipaddr_num | (~$netmask_num);

                if ($ip >= $addrs ['NETWORK'] && $ip <= $addrs ['BROADCAST']) {
                    return true;
                }
            }
        }

        return false;
    }
}
