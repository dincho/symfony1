<?php

/**
 * ip actions.
 *
 * @package    PolishRomance
 * @subpackage ip
 * @author     Dincho Todorov <dincho at xbuv.com>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class ipwatchActions extends sfActions
{
  /**
   * Executes index action
   *
   */
    public function preExecute()
    {
        //breadcrumb
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'IP Watch', 'uri' => 'ipwatch/index'));
    }


    public function executeIndex()
    {
        $this->redirect('ipwatch/residence');
    }

    public function executeResidence()
    {
        $this->getUser()->getBC()->add(array('name' => 'IP vs. Residence', 'uri' => 'ipwatch/residence'));
    }

    public function executeDuplicates()
    {
        $this->getUser()->getBC()->add(array('name' => 'IP Duplicates', 'uri' => 'ipwatch/duplicates'));
        
        $this->getResponse()->addJavascript('preview.js');

        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT t.ip, count(t.member_id) as count 
                FROM (
                	SELECT ip as ip, member_id FROM `member_login_history` WHERE ip!=0
                	union
                	select m.last_ip , m.id from  member m 
                	union
                	select m.registration_ip, m.id from  member m 
                ) t 
                GROUP by t.ip
                HAVING count(t.member_id) > 1;';
               
        $this->pager = new myArrayPager(null, $this->getRequestParameter('per_page',15));
        $this->pager->setResultArray( $customObject->query($sql) );
        $this->pager->setPage($this->getRequestParameter('page',1));
        $this->pager->init();
    }

    public function executeBlacklisted()
    {
        $this->getUser()->getBC()->add(array('name' => 'IP Blacklisted', 'uri' => 'ipwatch/blacklisted'));
        $this->getResponse()->addJavascript('preview.js');

        $customObject = new CustomQueryObject();
        
        $sql = 'SELECT t.ip, count(t.member_id) as count, get_maxmind_location(t.ip) as location 
                FROM ( SELECT DISTINCT ip as ip, member_id FROM `member_login_history` 
                        WHERE ip!=0 and ip in ( SELECT ip FROM ipwatch )
	                      GROUP by ip, member_id) t 
                GROUP by t.ip;';
               
        $this->pager = new myArrayPager(null, $this->getRequestParameter('per_page',15));
        $this->pager->setResultArray( $customObject->query($sql) );
        $this->pager->setPage($this->getRequestParameter('page',1));
        $this->pager->init();
    }

    public function executeBlacklist()
    {
        $bc = $this->getUser()->getBC()->add(array('name' => 'IP Blacklist', 'uri' => 'ipwatch/blacklist'));

        $this->ipwatch = IpwatchPeer::doSelect(new Criteria());

    }

    public function executeAddWatch()
    {
        $this->left_menu_selected = 'IP Blacklist';
        $bc = $this->getUser()->getBC()->add(array('name' => 'IP Blacklist', 'uri' => 'ipwatch/blacklist'))
            ->add(array('name' => 'New IP', 'uri' => 'ipwatch/addWatch'));
        
        if ($this->getRequestParameter('ip'))
        {
            $ipblock = new Ipwatch();
            $ipblock->setIP(ip2long($this->getRequestParameter('ip')));
            $ipblock->save();
            $this->redirect('ipwatch/blacklist');
        }

    }
    
    
    public function validateAddWatch()
    {
        return $this->_validateIP();
    }

    private function _validateIP()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $ip = $this->getRequestParameter('ip', '');
            if( ! Tools::isValidIp($ip) )
            {
                $this->getRequest()->setError('IP', 'Please enter a valid IP ');
                return false;
            }
        }
        
        return true;
    }

    public function handleErrorAddWatch()
    {
        $this->left_menu_selected = 'IP Blacklist';
        $bc = $this->getUser()->getBC()->clear()->add(array('name' => 'IP Watch', 'uri' => 'ipwatch/index'))
            ->add(array('name' => 'IP Blacklist', 'uri' => 'ipwatch/blacklist'))
            ->add(array('name' => 'New IP', 'uri' => 'ipwatch/addWatch'));

        return sfView::SUCCESS;
    }

    public function executeEditWatch()
    {
        $this->left_menu_selected = 'IP Blacklist';
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'IP Watch', 'uri' => 'ipwatch/index'));
        $bc = $this->getUser()->getBC()->add(array('name' => 'IP Blacklist', 'uri' => 'ipwatch/blacklist'))
            ->add(array('name' => 'Edit IP ', 'uri' => 'ipwatch/editWatch'));
        
        $this->ipwatch = IpwatchPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404unless($this->ipwatch);

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->ipwatch->setIP(ip2long($this->getRequestParameter('ip')));
            $this->ipwatch->save();
            $this->redirect('ipwatch/blacklist');
        }
    }
    
    public function validateEditWatch()
    {
        return $this->_validateIP();
    }

    public function handleErrorEditWatch()
    {
        $this->left_menu_selected = 'IP Blacklist';
        $bc = $this->getUser()->getBC()->clear()->add(array('name' => 'IP Watch', 'uri' => 'ipwatch/index'))
            ->add(array('name' => 'IP Blacklist', 'uri' => 'ipwatch/blacklist'))
            ->add(array('name' => 'Edit IP ', 'uri' => 'ipwatch/editWatch'));

        $this->ipwatch = IpwatchPeer::retrieveByPk($this->getRequestParameter('id'));
        $this->forward404unless($this->ipwatch);
        
        return sfView::SUCCESS;
    }

    public function executeDeleteWatch()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $marked = $this->getRequestParameter('marked', false);
            if (! is_null($this->getRequestParameter('delete')) && is_array($marked) && ! empty($marked))
            {
                $c = new Criteria();
                $c->add(IpwatchPeer::ID, $marked, Criteria::IN);
                IpblockPeer::doDelete($c);
                $this->setFlash('msg_ok', 'Selected IP have been deleted.');
            }
        }
        $this->redirect('ipwatch/blacklist');
    }

    public function executeAddToList()
    {

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $marked = $this->getRequestParameter('marked', false);
            if ( !is_null($this->getRequestParameter('add_to_blacklist')) && is_array($marked) && ! empty($marked))
            {                
                $con = Propel::getConnection(IpwatchPeer::DATABASE_NAME);
                try {
                	$con->begin();
                	foreach($marked as $ip)
                	{
                    $ipwatch = new Ipwatch();
                    $ipwatch->setIP( $ip );
                    $ipwatch->save();
                  }
                	$con->commit();
                  $this->setFlash('msg_ok', 'Selected IP have been added to blacklist.');
                } catch (PropelException $e) {
                	$con->rollback();
                  $this->setFlash('msg_error', 'Error - '. $e->getMessage ( )  );
                } 
           }
            else if ( !is_null($this->getRequestParameter('add_to_block')) && is_array($marked) && ! empty($marked))
            {                
                $con = Propel::getConnection(IpblockPeer::DATABASE_NAME);
                try {
                	$con->begin();
                	foreach($marked as $ip)
                	{
                    $ipblock = new Ipblock();
                    $ipblock->setItem( long2ip($ip) );
                    $ipblock->setItemType( 2 ); //  2 => 'Single IP',
                    $ipblock->save();
                  }
                	$con->commit();
                  $this->setFlash('msg_ok', 'Selected IP have been added to IP blocking.');
                } catch (PropelException $e) {
                	$con->rollback();
                  $this->setFlash('msg_error', 'Error - '. $e->getMessage ( )  );
                } 
           }
        }
        $this->redirect('ipwatch/duplicates');
    }

}
