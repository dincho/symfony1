<?php
class refererFilter extends sfFilter
{

    public function execute($filterChain)
    {
        if ($this->isFirstCall())
        {
            $context = $this->getContext();
            $request = $context->getRequest();
            $response = $context->getResponse();
            
            if ( $request->getMethod() == sfRequest::GET &&
                 !$request->isXmlHttpRequest() &&
                 !$request->hasParameter('layout') &&
                 $response->getStatusCode() != 404
               )
            {
                $user = $context->getUser();
                $stack = $user->getAttributeHolder()->getAll($this->getParameter('namespace'));
                $internal_url = sfRouting::getInstance()->getCurrentInternalUri();
                if ( !isset($stack[0]) || $stack[0] != $internal_url)
                {
                    array_unshift($stack, $internal_url);
                    $stack = array_slice($stack, 0, 2, false);
                    $user->getAttributeHolder()->removeNamespace($this->getParameter('namespace'));
                    $user->getAttributeHolder()->add($stack, $this->getParameter('namespace'));
                }
            }
        }
        $filterChain->execute();
    }
}
