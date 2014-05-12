<?php
class prPrivacyValidator extends sfValidator
{
    protected $sender;
    protected $receiver;

    public function setProfiles(BaseMember $sender, BaseMember $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    public function execute(&$value, &$error)
    {
       if ( $this->getParameter('check_open_privacy') &&
           $this->receiver->getPrivateDating() &&
           !$this->receiver->hasOpenPrivacyFor($this->sender->getId()) )
       {
           $error = $this->getParameter('open_privacy_error');

           return false;
       }

       if ( $this->getParameter('check_block') && $this->receiver->hasBlockFor($this->sender->getId()) ) {
           $error = $this->getParameter('block_error');

           return false;
       }

       if ( $this->getParameter('check_sex') &&
            ($this->receiver->getLookingFor() != $this->sender->getSex() || $this->sender->getLookingFor() != $this->receiver->getSex()) )
       {
           $error = $this->getParameter('sex_error');

           return false;
       }

       if ( $this->getParameter('check_onlyfull') && $this->sender->getSubscriptionId() != SubscriptionPeer::VIP && $this->receiver->getContactOnlyFullMembers() ) {
           $error = $this->getParameter('onlyfull_error');

           return false;
       }

       if ($this->getParameter('check_catalog')) {
           $sharedCatalogs = explode(',', $this->sender->getCatalogue()->getSharedCatalogs());

           if( !($this->sender->getCatalogId() == $this->receiver->getCatalogId()
               || in_array($this->receiver->getCatalogId(), $sharedCatalogs))
           ) {
               $error = $this->getParameter('catalog_error');

               return false;
           }
       }

       if ( $this->getParameter('check_blocked') && $this->sender->hasBlockFor($this->receiver->getId()) ) {
           $error = $this->getParameter('blocked_error');

           return false;
       }

        return true;
    }

    public function initialize($context, $parameters = null)
    {
        // Initialize parent
        parent::initialize ( $context );

        $this->setParameter('check_block', true);
        $this->setParameter('check_sex', true);
        $this->setParameter('check_onlyfull', true);
        $this->setParameter('check_open_privacy', true);
        $this->setParameter('check_catalog', true);
        $this->setParameter('check_blocked', true);

        $this->setParameter('block_error', 'This member has blocked you');
        $this->setParameter('sex_error', 'Due to privacy restrictions you cannot interact with this profile');
        $this->setParameter('onlyfull_error', 'Due to privacy restrictions you cannot interact with this profile');
        $this->setParameter('open_privacy_error', 'Due to privacy restrictions you cannot interact with this profile');
        $this->setParameter('catalog_error', 'Due to privacy restrictions you cannot interact with this profile - catalog');
        $this->setParameter('blocked_error', 'You have blocked profile and cannot interact with it.');

        // Set parameters
        $this->getParameterHolder ()->add($parameters);

        return true;
    }
}
