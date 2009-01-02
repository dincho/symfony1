<?php

/**
 * Subclass for performing query and update operations on the 'member_imbra' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MemberImbraPeer extends BaseMemberImbraPeer
{
    public static function retrieveByPKWithI18N($id, $culture)
    {
        $c = new Criteria();
        $c->add(MemberImbraPeer::ID, $id);
        $c->setLimit(1);
        
        $imbras = MemberImbraPeer::doSelectWithI18n($c, $culture);
        
        return (isset($imbras[0])) ? $imbras[0] : null;
    }
}
