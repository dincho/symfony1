<?php

/**
 *
 * 
 *
 * @package lib.model
 */ 
class MemberMatch
{
    protected $score;
    protected $reverseScore;

    public static function getMaxScore()
    {
        return sfConfig::get('app_matches_max_weight')
               *
               sfConfig::get('app_matches_nb_desc_quesitons');
    }

    public function setScore($score)
    {
        $this->score = (int) $score;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getPct()
    {
        return (int) round($this->getScore() / self::getMaxScore() * 100);
    }

    public function setReverseScore($score)
    {
        $this->reverseScore = (int) $score;
    }

    public function getReverseScore()
    {
        return $this->reverseScore;
    }

    public function getReversePct()
    {
        return (int) round($this->getReverseScore() / self::getMaxScore() * 100);
    }

    public function getCombinedPct()
    {
        return round(($this->getPct() + $this->getReversePct()) / 2);
    }
}


