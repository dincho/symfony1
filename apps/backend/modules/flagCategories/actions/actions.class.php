<?php

/**
 * flagCategories actions.
 *
 * @package    PolishRomance
 * @subpackage flagCategories
 * @author     Dincho Todorov <dincho
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class flagCategoriesActions extends sfActions
{

    public function preExecute()
    {
        $this->top_menu_selected = 'flags';
        $this->getUser()->getBC()->replaceFirst(array('name' => 'Flag Rules', 'uri' => 'flagCategories/edit'));
    }

    public function executeList()
    {
        $this->forward('flagCategories', 'edit');
    }

    public function executeEdit()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('flags_edit'));
            
            sfSettingPeer::updateFromRequest(array('flags_num_auto_suspension', 'flags_comment_field'));
            
            $req_categories = $this->getRequestParameter('categories');
            $categories = FlagCategoryPeer::getAssoc();
            if (is_array($req_categories) && ! empty($req_categories))
            {
                foreach ($req_categories as $req_category_id => $req_category_title)
                {
                    if (array_key_exists($req_category_id, $categories))
                    {
                        $categories[$req_category_id]->setTitle($req_category_title);
                        $categories[$req_category_id]->save();
                    } else
                    {
                        $new_category = new FlagCategory();
                        $new_category->setTitle($req_category_title);
                        $new_category->save();
                    }
                }
            }
            
            $this->redirect('flagCategories/edit?confirm_msg=' . confirmMessageFilter::OK);
        }
        
        $this->categories = FlagCategoryPeer::doSelect(new Criteria());
    }
}
