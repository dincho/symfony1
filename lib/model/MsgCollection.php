<?php

/**
 * Subclass for representing a row from the 'msg_collection' table.
 *
 *
 *
 * @package lib.model
 */
class MsgCollection extends BaseMsgCollection
{
    public function __toString()
    {
        return $this->getTransCollection() . ' - ' . $this->getName();
    }
}
