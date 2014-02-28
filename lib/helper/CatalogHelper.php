<?php

function select_catalog2url($catalogs, $url, $selected_cat_id = null, $options = array())
{
    if( empty($catalogs) ) $catalogs = CataloguePeer::getAll();
    
    $url .= ( strstr($url, '?') === false ) ? '?' : '&';
    $option_tags = array();
    $selected = null;
    $options['onchange'] = 'if(this.value) document.location.href = this.value;';
    
    foreach ($catalogs as $catalog)
    {
        $location_url = $url . 'cat_id=' .$catalog->getCatId();
        $location_url = url_for($location_url, array('absolute' => true));
        $option_tags[$location_url] = $catalog->__toString();
        if($catalog->getCatId() == $selected_cat_id) $selected = $location_url;
    }
    
    $option_tags = options_for_select($option_tags, $selected, $options);
    $name = $id = 'select_catalog2url';

    return content_tag('select', $option_tags, array_merge(array('name' => $name, 'id' => get_id_from_name($id)), $options));
}

function options4select_catalog($selected_cat_id = null)
{
    $options = array();
    $catalogs = CataloguePeer::getAll();

    foreach ($catalogs as $catalog)
    {
        if ($catalog->getCatId() != $selected_cat_id)
        {
            $options[$catalog->getCatId()] = $catalog->__toString();
        }
    }
    // why does objects_for_select() not work ???
    return  options_for_select($options, $selected_cat_id);
}