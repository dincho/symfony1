<?php
class refererFilter extends sfFilter
{

    public function execute($filterChain)
    {
        if ($this->isFirstCall())
        {
            $context = $this->getContext();
            if ($context->getRequest()->getMethod() == sfRequest::GET)
            {
                $user = $context->getUser();
                $stack = $user->getAttributeHolder()->getAll('frontend/member/referer_stack');
                $internal_url = sfRouting::getInstance()->getCurrentInternalUri();
                if ( !isset($stack[0]) || $stack[0] != $internal_url)
                {
                    array_unshift($stack, $internal_url);
                    $stack = array_slice($stack, 0, 2, false);
                    $user->getAttributeHolder()->removeNamespace('frontend/member/referer_stack');
                    $user->getAttributeHolder()->add($stack, 'frontend/member/referer_stack');
                }
            }
        }
        $filterChain->execute();
    }
}
