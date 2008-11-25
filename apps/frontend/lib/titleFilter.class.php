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
            sfLoader::loadHelpers(array('Partial'));
            $title = (!has_slot('header_title')) ? ucfirst($last_bc) : get_slot('header_title');
            $response->setTitle('PolishRomance - ' . $title);
        }
        $filterChain->execute();
    }
}
