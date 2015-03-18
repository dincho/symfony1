<?php

/**
 * Subclass for representing a row from the 'gift' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Gift extends BaseGift
{
    public function getExpiresAt()
    {
        $giftExpires = new DateTime($this->getCreatedAt());

        return $giftExpires->add(new DateInterval('P' . sfConfig::get('app_gifts_expire_days') . 'D'));
    }

    public function isExpired()
    {
        return $this->getAccepted() || $this->getExpiresAt() < new DateTime();
    }
}
