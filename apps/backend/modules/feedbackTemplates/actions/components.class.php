<?php

class FeedbackTemplatesComponents extends sfComponents
{
    public function executeTemplatePager()
    {
        $pager_crit = $this->getUser()->getAttribute('criteria', new Criteria(), 'backend/feedbackTemplates/template_pager');
        $this->pager = new TemplatePager($pager_crit, $this->template->getId());
        $this->pager->init();
    }
}
