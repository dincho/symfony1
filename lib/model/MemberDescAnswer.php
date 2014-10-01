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
        $values = array_filter(array_unique($values));

        $val_arr = array();
        for ($i=0; $i<5; $i++) {
            if ( isset($values[$i]) && $values[$i] ) {
                $level = ($values[$i]) ? $values['lang_levels'][$i] : null;
                $val_arr[] = array( 'lang' => $values[$i], 'level' => $level);
            }
        }

        $this->setCustom(serialize($val_arr));
    }

    public function getOtherLangs()
    {
        return unserialize($this->getCustom());
    }
}
