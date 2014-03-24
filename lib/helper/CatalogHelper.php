<?php
use_helper('Object');

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

function catalogOptions($selected_cat_id = null)
{
    $c = new Criteria();
    $c->add(CataloguePeer::CAT_ID, $selected_cat_id, Criteria::NOT_EQUAL);
    $catalogs = CataloguePeer::getAll($c);
    return  objects_for_select($catalogs, 'getCatId', '__toString', $selected_cat_id);
}
