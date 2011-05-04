<?php

function hover_image_tag($image, $hover_image, $options = array())
{
  return image_tag($image, array_merge(  
    array('onmouseover' => 'this.src="/images/'.$hover_image.'"',
          'onmouseout'  => 'this.src="/images/'.$image.'"'),
          _convert_options($options))); 
}


