<?php
class ipblockFilter extends sfFilter
{

    protected function redirect2blockedpage()
    {
        $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
        $AI->redirect('@blocked_user');
    }

    public function execute($filterChain)
    {
        if($this->isFirstCall())
        {
            $context = $this->getContext();
            $user = $context->getUser();
            //filter only when user logged in
            
            if($user->isAuthenticated() && !eregi('.+blocked_user', $context->getRequest()->getUri()) && !eregi('.+signout', $context->getRequest()->getUri()))
            {
                //check if already blocked
                if($context->getUser()->hasAttribute('ipblocked'))
                {
                    $this->redirect2blockedpage();
                } elseif(!$user->hasAttribute('not_ipblocked'))
                {
                    //if not_ipblocked is set, the user is not blocked, do not check
                    if( IpblockPeer::hasBlockFor($user->getAttribute('email'), $_SERVER['REMOTE_ADDR']) )
                    {
                        //user is blocked
                        $user->setAttribute('ipblocked', true);
                        $this->redirect2blockedpage();
                    } else
                    {
                        $user->setAttribute('not_ipblocked', true);
                    }
                
                }
            
            }
        }
        
        $filterChain->execute();
    }
}
