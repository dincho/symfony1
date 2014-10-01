<?php
class SessionVarRedirectFilter extends sfFilter
{

    public function execute($filterChain)
    {
        if ($this->isFirstCall()) {
            $context = $this->getContext();

            $request = $this->getContext()->getRequest();

            if ( $request->getParameter('PRSSID') ) {
                $uri = sfRouting::getInstance()->getCurrentInternalUri();
                $uri = preg_replace('#\?PRSSID=.*#', '', $uri);

                $AI = $context->getActionStack()->getLastEntry()->getActionInstance();
                $AI->redirect($uri);
            }

        }

        $filterChain->execute();
    }
}
