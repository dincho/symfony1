<?php

function error_class($field, $just_the_class_name = false)
{
    $request = sfContext::getInstance()->getRequest();
    $error_class = 'field_error';
    
    if ($request->hasErrors() && $request->hasError($field))
    {
        if ($just_the_class_name)
        {
            return $error_class;
        } else
        {
            return 'class=' . $error_class;
        }
    }
}

function object_bool_select_tag($object, $method, $options = array(), $default_value = 0)
{
    $select_options = array(1 => 'yes', 0 => 'no');
    $options['class'] = 'bool_select';
    $options = _parse_attributes($options);
    
    if (is_object($object))
    {
        $value = (int) _get_object_value($object, $method, $default_value); //cast the result so the "0" can be used
    } else
    {
        $value = $object;
    }
    
    $option_tags = options_for_select($select_options, $value, $options);
    
    return select_tag(_convert_method_to_name($method, $options), $option_tags, $options);
}

function bool_select_tag($name, $options = array(), $value = 0)
{
    $options['class'] = 'bool_select';
    $options = _convert_options($options);
    $id = $name;
    
    $option_tags = options_for_select(array(1 => 'yes', 0 => 'no'), $value); //default to no/false
    

    return content_tag('select', $option_tags, array_merge(array('name' => $name, 'id' => get_id_from_name($id)), $options));
}

function pr_label_for($id, $label = null, $options = array(), $translate = true)
{
    if (is_null($label))
        $label = ucfirst($id);
    
    $request = sfContext::getInstance()->getRequest();
    
    if ($request->hasErrors() && $request->hasError($id))
    {
        if (array_key_exists('class', $options))
        {
            $options['class'] .= ' error';
        } else
        {
            $options = array_merge($options, array('class' => 'error'));
        }
    }
    
    if (! array_key_exists('id', $options))
    {
        $options = array_merge($options, array('id' => 'label_' . get_id_from_name($id, null)));
    }
    
    return label_for($id, $label, $options);
}

function content_tag_with_error($name, $content = '', $options = array())
{
	$request = sfContext::getInstance()->getRequest();
	
    if ($request->hasErrors() && $request->hasError($options['id']))
    {
        if (array_key_exists('class', $options))
        {
            $options['class'] .= ' error';
        } else
        {
            $options = array_merge($options, array('class' => 'error'));
        }
    }
    	
    $options['id'] = get_id_from_name($options['id'], null);
	return content_tag($name, $content, $options);
}

function looking_for_options($selected = '', $html_options = array())
{
	$t = sfContext::getInstance()->getI18N();
    $options = array('M_F' => $t->__('Man looking for woman'), 'F_M' => $t->__('Woman looking for man'), 
                     'M_M' => $t->__('Man looking for man'), 'F_F' => $t->__('Woman looking for woman'));
    
    return options_for_select($options, $selected, $html_options);
}

function pr_select_country_tag($name, $selected = null, $options = array())
{
    $c = new sfCultureInfo(sfContext::getInstance()->getUser()->getCulture());
    $countries = $c->getCountries();
    
    if ($country_option = _get_option($options, 'countries'))
    {
        foreach ($countries as $key => $value)
        {
            if (!in_array($key, $country_option))
            {
                unset($countries[$key]);
            }
        }
    }
    
    asort($countries);
    $new_countries = array();
    
    $last_char = '';
    foreach ($countries as $key => $value)
    {
        $char = mb_substr($value, 0, 1, 'utf-8');
        
        if( $char != $last_char )
        {
            $new_countries[] = $char . '------------------------------------------';
        }
        $new_countries[$key] = $value; 
        $last_char = $char;
    }
        
    $option_tags = options_for_select($new_countries, $selected, $options);
    
    
    
    $option_tags = content_tag('option', $countries['CA'], array('value' => 'CA'))."\n" . $option_tags;
    $option_tags = content_tag('option', $countries['IE'], array('value' => 'IE'))."\n" . $option_tags;
    $option_tags = content_tag('option', $countries['GB'], array('value' => 'GB'))."\n" . $option_tags;
    $option_tags = content_tag('option', $countries['PL'], array('value' => 'PL'))."\n" . $option_tags;
    $option_tags = content_tag('option', $countries['US'], array('value' => 'US'))."\n" . $option_tags;
    if( isset($options['include_custom']) )
    {
    	$option_tags = content_tag('option', $options['include_custom'], array('value' => null))."\n" . $option_tags;
    }
        
    unset($options['include_blank'], $options['include_custom']);
    return select_tag($name, $option_tags, $options);
}

function pr_select_language_tag($name, $selected = null, $options = array())
{
    unset($options['include_blank'], $options['include_custom']);
    $enabled_languages = array("ab", "ace", "ach", "ada", "ady", "aa", "af", "ak", "sq", "ale", "alg", "am", "ar", "an", "arc", "arn", "hy", "as", "ast", "av", "awa", "ay", "az", "ban", "bal", "bm", "bad", "bas", "ba", "eu", "btk", "bej", "be", "bem", "bn", "ber", "bho", "bik", "bin", "bi", "bs", "br", "bug", "bg", "bua", "my", "ca", "ceb", "ch", "ce", "chr", "zh", "cho", "chk", "cv", "cop", "kw", "co", "cr", "crh", "hr", "cs", "da", "dar", "din", "dv", "doi", "dua", "nl", "dyu", "dz", "efi", "en", "myv", "eo", "et", "ee", "ewo", "fan", "fat", "fo", "fj", "fi", "fon", "fr", "fy", "fur", "ff", "gaa", "gl", "lg", "gay", "gba", "ka", "de", "gil", "gon", "gor", "el", "gn", "gu", "ht", "ha", "haw", "he", "hz", "hil", "him", "hi", "ho", "hmn", "hu", "iba", "is", "ig", "ijo", "ilo", "id", "inh", "iu", "ik", "ga", "it", "ja", "jv", "jrb", "jpr", "kbd", "kab", "kac", "kl", "xal", "kam", "kn", "kr", "kaa", "krc", "kar", "ks", "csb", "kk", "kha", "km", "ki", "kmb", "rw", "ky", "kv", "kg", "kok", "ko", "kpe", "kj", "kum", "ku", "kru", "lad", "lah", "lam", "lo", "la", "lv", "lez", "li", "ln", "lt", "nds", "dsb", "loz", "lu", "lua", "lun", "luo", "lus", "lb", "mk", "mad", "mag", "mai", "mak", "mg", "ms", "ml", "mt", "mnc", "mni", "gv", "mi", "mr", "chm", "mh", "mwr", "mas", "myn", "men", "min", "mdf", "mo", "lol", "mn", "mos", "nah", "na", "nv", "nd", "nr", "ng", "nap", "ne", "new", "nia", "nog", "se", "no", "nb", "nn", "nym", "ny", "nyn", "nyo", "nzi", "oc", "oj", "or", "om", "os", "pau", "pam", "pag", "pap", "ps", "fa", "pl", "pt", "pa", "qu", "raj", "rar", "roa", "ro", "rom", "rn", "ru", "sm", "sg", "sa", "sat", "sc", "sas", "sco", "gd", "sr", "srr", "shn", "sn", "ii", "sid", "sd", "si", "sk", "sl", "so", "son", "snk", "nso", "st", "sma", "es", "suk", "su", "sus", "sw", "ss", "sv", "syr", "tl", "ty", "tg", "tmh", "ta", "tt", "te", "tet", "th", "bo", "tig", "ti", "tem", "tiv", "tpi", "tkl", "tog", "to", "ts", "tn", "tum", "tr", "tk", "tvl", "tyv", "tw", "udm", "ug", "uk", "umb", "hsb", "ur", "uz", "vai", "ve", "vi", "wal", "wa", "war", "cy", "wo", "xh", "sah", "yao", "yi", "yo", "znd", "za", "zu");
    
    $c = new sfCultureInfo('en'); //other language list than english are not full
    $languages = $c->getLanguages();
    
    foreach ($languages as $key => $value)
    {
        if (! in_array($key, $enabled_languages))
        {
            unset($languages[$key]);
        }
    }
    
    asort($languages);
    $new_languages = array();
    
    foreach ($languages as $key => $value)
    {
        $char = mb_substr($value, 0, 1, 'utf-8');
        $opt_key = '-------------' . $char . '-------------';
        $new_languages[$opt_key][$key] = $value; 
    }

    
    $option_tags = options_for_select($new_languages, $selected, $options);
    $option_tags = content_tag('option', $languages['en'], array('value' => 'en'))."\n" . $option_tags;
    $option_tags = content_tag('option', $languages['pl'], array('value' => 'pl'))."\n" . $option_tags;
    $option_tags = content_tag('option', 'Select Language', array('value' => ''))."\n" . $option_tags;
    
    return select_tag($name, $option_tags, $options);

}

function pr_select_state_tag($country = 'US', $name, $selected = null, $options = array())
{
    use_helper('Object');
    
    $states = StatePeer::getAllByCountry($country);
    $options_for_select = objects_for_select($states, 'getId', 'getTitle', $selected);
    unset($options['include_custom'], $options['include_blank']);
    
    return select_tag($name, $options_for_select, $options);
}

function pr_object_select_state_tag($object, $method, $options = array(), $default_value = null)
{
    use_helper('Object');
    
    $options = _parse_attributes($options);
    
    $related_class = _get_option($options, 'related_class', false);
    if (false === $related_class && preg_match('/^get(.+?)Id$/', $method, $match))
    {
        $related_class = $match[1];
    }
    
    $text_method = _get_option($options, 'text_method');
    
    $country = sfContext::getInstance()->getRequest()->getParameter('country', $object->getCountry());
    $states = StatePeer::getAllByCountry($country);
    $select_options = _get_options_from_objects($states, $text_method);
    
    if ($value = _get_option($options, 'include_custom'))
    {
        $select_options = array('' => $value) + $select_options;
    } else if (_get_option($options, 'include_title'))
    {
        $select_options = array('' => '-- ' . _convert_method_to_name($method, $options) . ' --') + $select_options;
    } else if (_get_option($options, 'include_blank'))
    {
        $select_options = array('' => '') + $select_options;
    }
    
    if (is_object($object))
    {
        $value = _get_object_value($object, $method, $default_value);
    } else
    {
        $value = $object;
    }
    
    $option_tags = options_for_select($select_options, $value, $options);
    
    return select_tag(_convert_method_to_name($method, $options), $option_tags, $options);
}

function pr_select_language_level($name, $selected = null, $options = array())
{
    $levels = array(1 => 'Fluent', 2 => 'Good', 3 => 'Basic', 4 => 'Translation Needed');
    
    $options_select = $options;
    unset($options_select['include_custom']);
    
    return select_tag($name, options_for_select($levels, $selected, $options), $options_select);
}

function pr_format_language_level($key = null)
{
    $levels = array(1 => 'Fluent', 2 => 'Good', 3 => 'Basic', 4 => 'Translation Needed');
    
    return array_key_exists($key, $levels) ? $levels[$key] : null;
}

function pr_select_match_weight($name, $selected = null, $options = array())
{
    //var_dump($selected);exit();
    $weights = array(21 => 'Very Important', 8 => 'Important', 3 => 'Somehow Important', 1 => 'Not Important');
    return select_tag($name, options_for_select($weights, $selected, $options), $options);
}

function pr_select_payment_period_type($name, $selected = null, $options = array())
{
    $types = array('D' => 'Day(s)', 'W' => 'Week(s)', 'M' => 'Month(s)', 'Y' => 'Year(s)');
    return select_tag($name, options_for_select($types, $selected, $options), $options);
}

function pr_format_payment_period_type($type)
{
    $types = array('D' => 'Day(s)', 'W' => 'Week(s)', 'M' => 'Month(s)', 'Y' => 'Year(s)');
    return (array_key_exists($type, $types)) ? $types[$type] : null;
}
?>