<?php
class prWebResponse extends sfWebResponse
{
    public function getMetas()
    {
        $meta_tags = $this->getParameterHolder ()->getAll ( 'helper/asset/auto/meta' );
        if ( array_key_exists ('title', $meta_tags) ) {
            unset($meta_tags ['title']);
        }
        return $meta_tags;
    }
}