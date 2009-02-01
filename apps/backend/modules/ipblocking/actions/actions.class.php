<?php

/**
 * ipblocking actions.
 *
 * @package    PolishRomance
 * @subpackage ipblocking
 * @author     Dincho Todorov <dincho at xbuv.com>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class ipblockingActions extends sfActions
{

    public function preExecute()
    {
        if ($this->getRequestParameter('cancel') == 1)
        {
            $this->setFlash('msg_error', 'You clicked Cancel, your changes have not been saved');
            $this->redirect($this->getModuleName() . '/' . $this->getActionName() . '?id=' . $this->getRequestParameter('id'));
        }
        
        $this->left_menu_selected = 'IP Blocking';
        $this->top_menu_selected = 'content';
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'Content', 'uri' => 'content/list'))->add(array('name' => 'IP Blocking', 'uri' => 'ipblocking/list'));
        $this->culture = ($this->getRequestParameter('culture', 'en'));
    }

    public function executeList()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(IpblockPeer::ITEM_TYPE);
        $c->addAscendingOrderByColumn(IpblockPeer::ITEM);
        $this->ipblocks = IpblockPeer::doSelect($c);
    }

    public function executeEdit()
    {
        $this->ipblock = IpblockPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404unless($this->ipblock);
        
        $this->getUser()->getBC()->add(array('name' => 'IP Block Edit', 'uri' => 'ipblocking/edit?id=' . $this->ipblock->getId()));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $this->ipblock->setItem($this->getRequestParameter('item'));
            $this->ipblock->setItemType($this->getRequestParameter('item_type'));
            $this->ipblock->setNetmask($this->getRequestParameter('netmask'));
            $this->ipblock->save();
            $this->redirect('ipblocking/list');
        }
    }

    public function handleErrorEdit()
    {
        $this->ipblock = IpblockPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404unless($this->ipblock);
        
        return sfView::SUCCESS;
    }

    public function executeAdd()
    {
        $this->getUser()->getBC()->add(array('name' => 'New IP Block', 'uri' => 'ipblocking/add'));
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $ipblock = new Ipblock();
            $ipblock->setItem($this->getRequestParameter('item'));
            $ipblock->setItemType($this->getRequestParameter('item_type'));
            $ipblock->setNetmask($this->getRequestParameter('netmask'));
            $ipblock->save();
            $this->redirect('ipblocking/list');
        }
    }

    public function handleErrorAdd()
    {
        return sfView::SUCCESS;
    }

    public function validateEdit()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $item_type = $this->getRequestParameter('item_type', - 1);
            $netmask = $this->getRequestParameter('netmask', '');
            $item = $this->getRequestParameter('item', '');
            if ($item_type == 3 && empty($netmask))
            {
                $this->getRequest()->setError('netmask', 'Please select a network mask');
                return false;
            }
            
            if (($item_type == 2 || $item_type == 3) && ! tools::ip_valid($item))
            {
                $this->getRequest()->setError('item', 'Please enter a valid IP ');
                return false;
            }
            
            if ($item_type == 1 && ! tools::validEmail($item))
            {
                $this->getRequest()->setError('item', 'Please enter a valid email address');
                return false;
            }
        }
        
        return true;
    }

    public function validateAdd()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $item_type = $this->getRequestParameter('item_type', - 1);
            $netmask = $this->getRequestParameter('netmask', '');
            $item = $this->getRequestParameter('item', '');
            if ($item_type == 3 && empty($netmask))
            {
                $this->getRequest()->setError('netmask', 'Please select a network mask');
                return false;
            }
            
            if (($item_type == 2 || $item_type == 3) && ! tools::ip_valid($item))
            {
                $this->getRequest()->setError('item', 'Please enter a valid IP ');
                return false;
            }
            
            if ($item_type == 1 && ! tools::validEmail($item))
            {
                $this->getRequest()->setError('item', 'Please enter a valid email address');
                return false;
            }
        }
        
        return true;
    }

    public function executeUpdate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->getUser()->checkPerm(array('content_edit'));
            $marked = $this->getRequestParameter('marked', false);
            if (! is_null($this->getRequestParameter('delete')) && is_array($marked) && ! empty($marked))
            {
                $c = new Criteria();
                $c->add(IpblockPeer::ID, $marked, Criteria::IN);
                IpblockPeer::doDelete($c);
                $this->setFlash('msg_ok', 'Selected blocks have been deleted.');
            }
        }
        $this->redirect('ipblocking/list?culture=' . $this->getRequestParameter('culture', 'en'));
    }

}
