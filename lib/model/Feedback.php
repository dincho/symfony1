<?php

/**
 * Subclass for representing a row from the 'feedback' table.
 *
 *
 *
 * @package lib.model
 */
class Feedback extends BaseFeedback
{
    public function getFrom()
    {
        return ($this->getMemberId()) ? $this->getMember()->getUsername() : $this->getMailFrom();
    }

    public function getTo()
    {
        return $this->getNameTo() . ' ' . '&lt;' . $this->getMailTo() .'&gt;';
    }

    public function isRead()
    {
        return $this->getIsRead();
    }

    public function exportToRequestParameters()
    {
        $request = sfContext::getInstance()->getRequest();
        $request->setParameter('mail_from', $this->getMailFrom());
        $request->setParameter('mail_to', $this->getMailTo());
        $request->setParameter('subject', $this->getSubject());
        $request->setParameter('body', $this->getBody());
    }

    public function getBodyForReply()
    {
        $_body = explode('<br />', $this->getBody());
        $ret = "\r\n\r\n\r\n";
        $from = ($this->getNameFrom()) ? $this->getNameFrom() : $this->getMailFrom();
        $ret .= 'On ' . $this->getCreatedAt('M d, Y H:i A, ') .  $from . ' wrote: ' . "\r\n";

        foreach ($_body as $line) {
            $ret .= '> ' . $line . "\r\n";
        }

        return $ret;
    }
}
