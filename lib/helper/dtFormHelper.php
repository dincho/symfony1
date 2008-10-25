<?php
function error_class($field, $just_the_class_name = false)
{
  $request = sfContext::getInstance()->getRequest();
  $error_class = 'field_error';
  
  if( $request->hasErrors() && $request->hasError($field) )
  {
    if( $just_the_class_name )
    {
      return $error_class;
    } else {
      return 'class=' . $error_class;
    }    
  }
}

function object_bool_select_tag($object, $method, $select_options = array(1 => 'yes', 0 => 'no'), $options = array(), $default_value = 0)
{
	$options['class'] = 'bool_select';
  $options = _parse_attributes($options);

  if (is_object($object))
  {
    $value = (int) _get_object_value($object, $method, $default_value); //cast the result so the "0" can be used
  }
  else
  {
    $value = $object;
  }

  $option_tags = options_for_select($select_options, $value, $options);

  return select_tag(_convert_method_to_name($method, $options), $option_tags, $options);	
}

function bool_select_tag($name, $options = array())
{
	$options['class'] = 'bool_select';
  $options = _convert_options($options);
  $id = $name;

  $option_tags = options_for_select(array(1 => 'yes', 0 => 'no'), 0); //default to no/false

  return content_tag('select', $option_tags, array_merge(array('name' => $name, 'id' => get_id_from_name($id)), $options));
}

function pr_label_for($id, $label = null, $options = array(), $translate = true)
{
    if( is_null($label) ) $label = ucfirst($id);
    
    $request = sfContext::getInstance()->getRequest();
    
    if( $request->hasErrors() && $request->hasError($id))
    {
        if( array_key_exists('class', $options) )
        {
            $options['class'] .= ' error';
        } else {
            $options = array_merge($options, array('class' => 'error'));
        }
    }
    
    if( !array_key_exists('id', $options) )
    {
        $options = array_merge($options, array('id' => 'label_' . get_id_from_name($id, null)));
    }
        
    return label_for($id, $label, $options);
}

function looking_for_options($selected = '', $html_options = array())
{
    $options = array('M_F' => 'Man looking for woman', 'F_M' => 'Woman looking for man', 'M_M' => 'Man looking for man', 'F_F' => 'Woman looking for woman');
    return options_for_select($options, $selected, $html_options);
}

function pr_select_country_tag($name, $selected = null, $options = array())
{
    return select_country_tag($name, $selected, $options);
}

function pr_select_language_tag($name, $selected = null, $options = array())
{
    return select_language_tag($name, $selected, $options);
}

function pr_select_state_tag($country = 'US', $name, $selected = null, $options = array())
{
    use_helper('Object');
    
    $states = StatePeer::getAllByCountry($country);
    $options_for_select = objects_for_select($states, 'getId', 'getTitle', $selected);
    
    return select_tag($name, $options_for_select, $options);
}

function pr_select_language_level($name, $selected = null, $options = array())
{
    $levels = array(1 => 'Fluent', 2=> 'Good', 3 => 'Basic', 4 => 'Translation Needed');
    
    return select_tag($name, options_for_select($levels, $selected, $options), $options);
}

function pr_format_language_level($key = null)
{
    $levels = array(1 => 'Fluent', 2=> 'Good', 3 => 'Basic', 4 => 'Translation Needed');
    
    return array_key_exists($key, $levels) ? $levels[$key] : null;
}

function pr_select_match_weight($name, $selected = null, $options = array())
{
    //var_dump($selected);exit();
    $weights = array(21 => 'Very Important', 8 => 'Important', 3 => 'Somehow Important', 1 => 'Not Important');
    return select_tag($name, options_for_select($weights, $selected, $options), $options);
}
?>