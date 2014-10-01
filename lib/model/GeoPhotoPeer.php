<?php

/**
 * Subclass for performing query and update operations on the 'geo_photo' table.
 *
 *
 *
 * @package lib.model
 */
class GeoPhotoPeer extends BaseGeoPhotoPeer
{
    public static function getAssistantPhotoByCulture($culture = 'en')
    {
        $c = new Criteria();
        $c->add(self::ASSISTANTS, $culture);
        $c->setLimit(1);

        return self::doSelectOne($c);
    }
}
