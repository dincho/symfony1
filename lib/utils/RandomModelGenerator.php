<?php
class RandomModelGenerator
{
    public static function generateMember()
    {
        $name = strtolower(RandomGenerator::getName());
        
        $member = new Member();
        $member->initNewMember();
        $member->setUsername($name);
        $member->setEmail($name . '@localhost');
        $member->setPassword('123qwe');
        $member->changeSubscription(SubscriptionPeer::FREE);
        $member->changeStatus(MemberStatusPeer::ABANDONED);
        $member->parseLookingFor('M_F');
        $member->setLastIp(ip2long('127.0.0.1'));
        $member->setRegistrationIp(ip2long('127.0.0.1'));
        $member->setLanguage('en');
        $member->setCatalogId(1); //used by notifications
        
        return $member;
    }
}