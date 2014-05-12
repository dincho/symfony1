<?php

/**
 * Subclass for representing a row from the 'feedback_template' table.
 *
 *
 *
 * @package lib.model
 */
class FeedbackTemplate extends BaseFeedbackTemplate
{
    public function __toString()
    {
        return $this->getName();
    }
}
