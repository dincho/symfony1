<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Nov 26, 2008 4:25:15 PM
 * 
 */
 

function fillIn($name, $type, $initValue= NULL, $checked=false){

    $request = sfContext::getInstance()->getRequest();
    $value   =  $request->getParameter($name);
    
    if($type=='text' || $type == 'textarea' || $type == 't')
    {
        // text input
        if (is_null($value))// && $value == $initValue
        {
            return $initValue;
        }
        else {
            return $value;
        }
    }
    else if ($type == 'checkbox' || $type == 'radio' || $type == 'c' || $type == 'r' )
    {
        // checkbox and radio
        if (!is_null($value) && !is_null($initValue) && ($value == $initValue))
        {
            return true;
        }
        else if(is_null($value)  && empty($_POST) && empty($_GET) && ($checked == true))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else if ($type == 'select' || $type == 's')
    {
        // select
        if(is_null($value))
        {
            return (array) $initValue;
        }
        else
        {
            if(is_array($value) || is_object($value))
            {
                $selected_options = array();
                foreach ($value as $val)
                {
                    array_push($selected_options, $val);//urldecode - prototype bug 
                }
                return  $selected_options;
            }
            else
            {
                return (array) $value;
            }
        }
    }

    return false;
}
