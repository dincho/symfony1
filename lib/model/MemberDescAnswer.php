<?php

/**
 * Subclass for representing a row from the 'member_desc_answer' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberDescAnswer extends BaseMemberDescAnswer
{
    public function setOtherLangs($values)
    {
        $val_arr = array();
        for($i=1; $i<5; $i++)
        {
            $level = ($values[$i]) ? $values['lang_levels'][$i] : null;
            $val_arr[$i] = array( 'lang' => $values[$i], 'level' => $level);
        }
        
        $this->setCustom(serialize($val_arr));
    }
    
    public function getOtherLangs()
    {
        return unserialize($this->getCustom());
    }
}
