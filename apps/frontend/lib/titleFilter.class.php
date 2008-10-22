<?php
class titleFilter extends sfFilter
{

    public function execute($filterChain)
    {
        if ($this->isFirstCall())
        {
            $context = $this->getContext();
            $bc = $context->getUser()->getBC();
            //$request = $this->getContext()->getRequest();
            $response = $this->getContext()->getResponse();

            $last_bc = ($bc->getLastName() == 'index') ? $context->getModuleName() : $bc->getLastName();
            $title = (! isset($action->header_title)) ? ucfirst($last_bc) : $action->header_title;
            $response->setTitle('PolishRomance - ' . $title);
        }
        $filterChain->execute();
    }
}
