<?php
function ___($text, $args = array(), $catalogue = 'messages')
{
    $sf_user = sfContext::getInstance()->getUser();
    $old_culture = $sf_user->getCulture();
    $sf_user->setCulture('en');
    $ret = __($text, $args, $catalogue);
    $sf_user->setCulture($old_culture);

    return $ret;

}
