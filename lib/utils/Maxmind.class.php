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
        $c->add(IpBlocksPeer::IP_POLY, 'MBRCONTAINS('.IpBlocksPeer::IP_POLY.', POINTFROMWKB(POINT(INET_ATON("'.$ip.'"), 0)))',  Criteria::CUSTOM);
        $c->setLimit(1);
        $reg_location =  IpLocationPeer::doSelectJoinAll($c);
        if (count($reg_location))
        {
          return  $reg_location[0]->getCityName() . ', ' . $reg_location[0]->getIpCountry()->getCountryName();
        } 
        return ''; 
    }

}
