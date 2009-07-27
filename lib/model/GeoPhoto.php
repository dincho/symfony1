<?php

/**
 * Subclass for representing a row from the 'geo_photo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class GeoPhoto extends BaseGeoPhoto
{
}

$sizes = array(array('width' => 100, 'height' => 100), //backend thumbnails
               );//backend full size when cropping
                
sfPropelBehavior::add('GeoPhoto', array('thumbnails' => array('file' => array('thumbSizes' => $sizes))));