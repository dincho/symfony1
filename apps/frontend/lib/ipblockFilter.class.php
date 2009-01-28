<?php
class ipblockFilter extends sfFilter
{
    protected function redirect2blockedpage()
    {
	 $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
	 $AI->redirect('@blocked_user');
	//$this->getContext()->getController()->redirect('/en/blocked_user.html');
	//$this->getContext()->getController()->redirect('@blocked_page');
    }

    public function execute($filterChain)
    {
        if ($this->isFirstCall())
        {
            $context = $this->getContext();
	    //filter only when user logged in

	    if ($context->getUser()->isAuthenticated() && !eregi('.+blocked_user', $context->getRequest()->getUri()))
	    {
	    //check if already blocked
		if ($context->getUser()->hasAttribute('ipblocked'))
		{
		    $this->redirect2blockedpage();
		}
		elseif (!$context->getUser()->hasAttribute('not_ipblocked'))
		{
		//if not_ipblocked is set, the user is not blocked, do not check
		    if (tools::check_ip_block())
		    {
			//user is blocked
			$context->getUser()->setAttribute('ipblocked', true);
			$this->redirect2blockedpage();
		    }
		    else
		    {
			$context->getUser()->setAttribute('not_ipblocked', true);
		    }
		
		}
	    
	    }
        }

        $filterChain->execute();
    }
}
