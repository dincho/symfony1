<?php

class GeoPager extends prBasePager
{
    public function __construct(Criteria $crit, $currentID)
    {
        parent::__construct('GeoPeer', $crit, $currentID);
    }
}
