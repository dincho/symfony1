<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Nov 24, 2008 9:38:12 PM
 * 
 */
 
class prActions extends sfActions
{
    public function message($msg_tpl)
    {
        $this->setFlash('msg_tpl', $msg_tpl);
        $this->redirect('content/message');
    }
}
