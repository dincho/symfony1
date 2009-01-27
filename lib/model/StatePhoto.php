<?php

/**
 * Subclass for representing a row from the 'state_photo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class StatePhoto extends BaseStatePhoto
{
}

$sizes = array(array('width' => 100, 'height' => 100), //backend thumbnails
               );//backend full size when cropping
                
sfPropelBehavior::add('StatePhoto', array('thumbnails' => array('file' => array('thumbSizes' => $sizes))));