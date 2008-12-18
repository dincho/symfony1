<?php
/**
 * imbra actions.
 *
 * @package    pr
 * @subpackage imbra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class imbraActions extends sfActions
{

    public function preExecute ()
    {
        $bc = $this->getUser()->getBC();
        $bc->clear()->add(array('name' => 'IMBRA', 'uri' => 'imbra/list'));
        $this->member = MemberPeer::retrieveByPK($this->getRequestParameter('member_id'));
        $this->processFilters();
        $this->filters = $this->getUser()->getAttributeHolder()->getAll('backend/imbra/filters');
    }

    public function postExecute ()
    {
        $bc = $this->getUser()->getBC();
        if (isset($this->filters) && array_key_exists('imbra_status_id', $this->filters))
        {
            switch ($this->filters['imbra_status_id']) {
                case 1:
                    $bc->add(array('name' => 'Approved', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=1'));
                    $this->left_menu_selected = 'Approved';
                    break;
                case 2:
                    $bc->add(array('name' => 'Pending', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=2'));
                    $this->left_menu_selected = 'Pending';
                    break;
                case 3:
                    $bc->add(array('name' => 'Denied', 'uri' => 'imbra/list?filter=filter&filters[imbra_status_id]=3'));
                    $this->left_menu_selected = 'Denied';
                    break;
                default:
                    break;
            }
        }
        if (isset($this->member))
        {
            $bc->add(array('name' => $this->member->getUsername(), 'uri' => 'members/edit?id=' . $this->member->getId()));
        }
    }

    public function executeList ()
    {
        $this->processSort();
        
        //default to pending imbra apps
        if (! isset($this->filters['imbra_status_id']))
            $this->filters['imbra_status_id'] = 2;
        $c = new Criteria();
        $this->addFiltersCriteria($c);
        $this->addSortCriteria($c);
        $this->imbra_applications = MemberImbraPeer::doSelectJoinAll($c);
    }

    public function executeEdit ()
    {
        $this->forward404Unless($this->member);
        $this->imbras = $this->member->getMemberImbras();
        $this->forward404Unless($this->imbras);
        $this->imbra = ($this->getRequestParameter('id')) ? MemberImbraPeer::retrieveByPK($this->getRequestParameter('id')) : $this->imbras[0];
    }

    public function executeDeny ()
    {
        $this->forward404Unless($this->member);
        $this->imbras = $this->member->getMemberImbras();
        $this->imbra = MemberImbraPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->imbra);
        
        if( $this->getRequestParameter('template_id') ) $this->template = ImbraReplyTemplatePeer::retrieveByPK($this->getRequestParameter('template_id'));
        if( !$this->template ) $this->template = ImbraReplyTemplatePeer::retrieveByPK(1);
        if( !$this->template ) $this->template = new ImbraReplyTemplate();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('save_as_new_template'))
            {
                $this->saveTemplate();
            }
            
            $mail = new prMail();
            $mail->setFrom($this->getRequestParameter('send_from'));
            $mail->addReplyTo($this->getRequestParameter('reply_to'));
            if( $this->getRequestParameter('bcc')) $mail->addBcc($this->getRequestParameter('bcc'));
            $mail->addAddress($this->member->getEmail(), $this->member->getFullName());
            
            $mail->setSubject($this->getRequestParameter('subject'));
            $mail->setBody($this->getRequestParameter('body'));
            $mail->Send();
            
            $this->imbra->setImbraStatusId(ImbraStatusPeer::DENIED);
            $this->imbra->save();
            
            $this->setFlash('msg_ok', 'IMBRA application have been denied.');
            $this->redirect('imbra/list');
        }
    }

    public function executeApprove ()
    {
        $this->forward404Unless($this->member);
        $this->imbras = $this->member->getMemberImbras();
        $this->forward404Unless($this->imbras);
        $this->imbra = MemberImbraPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->imbra);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->imbra->setText($this->getRequestParameter('text'));
            $this->imbra->setImbraStatusId(ImbraStatusPeer::APPROVED);
            $this->imbra->save();
            $this->redirect('imbra/approveConfirmation?id=' . $this->imbra->getId() . '&member_id=' . $this->member->getId() . '&template_id=3');
        }
    }

    public function executeApproveConfirmation()
    {
        $this->forward404Unless($this->member);
        $this->imbras = $this->member->getMemberImbras();
        $this->imbra = MemberImbraPeer::retrieveByPK($this->getRequestParameter('id'));
        $this->forward404Unless($this->imbra);
        
        if( $this->getRequestParameter('template_id') ) $this->template = ImbraReplyTemplatePeer::retrieveByPK($this->getRequestParameter('template_id'));
        if( !$this->template ) $this->template = ImbraReplyTemplatePeer::retrieveByPK(1);
        if( !$this->template ) $this->template = new ImbraReplyTemplate();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('save_as_new_template'))
            {
                $this->saveTemplate();
            }
            
            $mail = new prMail();
            $mail->setFrom($this->getRequestParameter('send_from'));
            $mail->addReplyTo($this->getRequestParameter('reply_to'));
            if( $this->getRequestParameter('bcc')) $mail->addBcc($this->getRequestParameter('bcc'));
            $mail->addAddress($this->member->getEmail(), $this->member->getFullName());
            
            $mail->setSubject($this->getRequestParameter('subject'));
            $mail->setBody($this->getRequestParameter('body'));
            $mail->Send();
            
            $this->imbra->setImbraStatusId(ImbraStatusPeer::DENIED);
            $this->imbra->save();
            
            $this->setFlash('msg_ok', 'Message has been sent.');
            $this->redirect('imbra/list');
        }
    }
        
    public function executeView ()
    {
    }

    protected function saveTemplate ()
    {
        $imbra_reply_template = new ImbraReplyTemplate();
        $imbra_reply_template->setTitle($this->getRequestParameter('save_as_new_template'));
        $imbra_reply_template->setSubject($this->getRequestParameter('subject'));
        $imbra_reply_template->setBody($this->getRequestParameter('body'));
        $imbra_reply_template->setMailFrom($this->getRequestParameter('mail_from'));
        $imbra_reply_template->setReplyTo($this->getRequestParameter('reply_to'));
        $imbra_reply_template->setBcc($this->getRequestParameter('bcc'));
        $imbra_reply_template->save();
    }

    protected function processSort()
    {
        $this->sort_namespace = 'backend/imbra/sort';
        
        if ($this->getRequestParameter('sort'))
        {
            $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), $this->sort_namespace);
            $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), $this->sort_namespace);
        }
        
        if (! $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $this->getUser()->setAttribute('sort', 'Member::created_at', $this->sort_namespace); //default sort column
            $this->getUser()->setAttribute('type', 'desc', $this->sort_namespace); //default order
        }
    }

    protected function addSortCriteria($c)
    {
        if ($sort_column = $this->getUser()->getAttribute('sort', null, $this->sort_namespace))
        {
            $sort_arr = $sort_column = explode('::', $sort_column);
            $peer = $sort_arr[0] . 'Peer';
            
            $sort_column = call_user_func_array(array($peer, 'translateFieldName'), array($sort_arr[1], BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME));
            if ($this->getUser()->getAttribute('type', null, $this->sort_namespace) == 'asc')
            {
                $c->addAscendingOrderByColumn($sort_column);
            } else
            {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }
        
    protected function processFilters ()
    {
        if ($this->getRequest()->hasParameter('filter'))
        {
            $filters = $this->getRequestParameter('filters');
            $this->getUser()->getAttributeHolder()->removeNamespace('backend/imbra/filters');
            $this->getUser()->getAttributeHolder()->add($filters, 'backend/imbra/filters');
        }
    }

    protected function addFiltersCriteria ($c)
    {
        if (isset($this->filters['imbra_status_id']))
        {
            $c->add(MemberImbraPeer::IMBRA_STATUS_ID, $this->filters['imbra_status_id']);
        }
    }
}
