<?php
/**
 *
 * @author vvidov
 * @version 1.0
 * @created Mar 7, 2011 21:47:49
 *
 */

class Maxmind
{
    public static function getMaxmindLocation($ip)
    {
        $c = new Criteria();
        $c->addJoin(IpCountryPeer::COUNTRY_CODE, IpLocationPeer::COUNTRY_CODE);
        $c->addJoin(IpLocationPeer::ID, IpBlocksPeer::LOCID);
        $c->add(IpBlocksPeer::IP_POLY, 'MBRCONTAINS('.IpBlocksPeer::IP_POLY.', POINTFROMWKB(POINT('.$ip.', 0)))',  Criteria::CUSTOM);
        $c->setLimit(1);

        if ($res =  IpLocationPeer::doSelectJoinAll($c)) {
            return  $res[0]->getCityName() . ', ' . $res[0]->getIpCountry()->getCountryName();
        } else {
            return 'unknown';
        }
    }
}
