<?php
class messagesComponents extends sfComponents
{
    public function executeSelectPredefinedMessage()
    {
        $member = $this->getUser()->getProfile();
        
        $c = new Criteria();
        $c->add(PredefinedMessagePeer::CATALOG_ID, $this->getUser()->getCatalogId());
        $crit1 = $c->getNewCriterion(PredefinedMessagePeer::SEX, $member->getSex());
        $crit1->addOr($c->getNewCriterion(PredefinedMessagePeer::SEX, ''));
        
        $crit2 = $c->getNewCriterion(PredefinedMessagePeer::LOOKING_FOR, $member->getLookingFor());
        $crit2->addOr($c->getNewCriterion(PredefinedMessagePeer::LOOKING_FOR, ''));
        
        $c->add($crit1);        
        $c->add($crit2);
        
        $this->messages = PredefinedMessagePeer::doSelect($c);
        
        $js_options = array();
        foreach($this->messages as $message)
        {
            $js_options[$message->getId()] = array('subject' => $message->getSubject(), 'body' => $message->getBody());
        }
        
        $this->js_options = json_encode($js_options);
    }
}