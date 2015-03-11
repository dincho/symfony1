<?php

class TemplatePager extends prBasePager
{
    public function __construct(Criteria $crit, $currentID)
    {
        parent::__construct('FeedbackTemplatePeer', $crit, $currentID);
    }
}
