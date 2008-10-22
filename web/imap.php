<?php
require_once '../lib/imap.class.php';
$imap = new IMAP();
$messages = $imap->getMessages();
?>