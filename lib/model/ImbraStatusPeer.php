<?php

/**
 * Subclass for performing query and update operations on the 'imbra_status' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ImbraStatusPeer extends BaseImbraStatusPeer
{
	const APPROVED = 1;
	const PENDING = 2;
	const DENIED = 3;
}
