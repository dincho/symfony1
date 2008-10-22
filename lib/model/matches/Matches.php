<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Oct 21, 2008 3:05:54 PM
 * 
 */
 
class Matches extends BaseMatches 
{
    const TOTAL_SCORES = 378;
    
    public function getReversePct()
    {
        return round($this->getReverseScore() / self::TOTAL_SCORES * 100);
    }
    
    public function getPct()
    {
        return round($this->getScore() / self::TOTAL_SCORES * 100);
        //return $this->getScore();
    }
}
