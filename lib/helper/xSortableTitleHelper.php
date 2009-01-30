<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Dec 5, 2008 9:12:58 PM
 * 
 */
 
function sortable_title($name, $var, $namespace, $sort_field = 'sort')
{
    $options = array();
    $context = sfContext::getInstance();
    $user = $context->getUser();
    $internal_uri = $context->getModuleName() . '/' . $context->getActionName();
    
    if( $user->getAttribute($sort_field, null, $namespace) == $var )
    {
        $type = ($user->getAttribute('type', 'asc', $namespace) == 'asc') ? 'desc' : 'asc';
        $internal_uri .= '?'.$sort_field.'=' . $var .'&type=' . $type;
        $options['class'] = 'sorted_by';
    } else {
        $internal_uri .= '?'.$sort_field.'=' . $var .'&type=asc';
    }
    
    return link_to($name, $internal_uri, $options);
}
