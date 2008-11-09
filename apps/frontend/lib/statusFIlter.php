<?php
/**
 * 
 * @author Dincho Todorov
 * @version 1.0
 * @created Sep 27, 2008 9:16:46 PM
 * 
 */
class statusFilter extends sfFilter
{

    public function execute($filterChain)
    {
        if ($this->isFirstCall())
        {
            $context = $this->getContext();
            $module = $context->getModuleName();
            $action = $context->getActionName();
            $user = $context->getUser();
            //second condition is to bypass case constructor if status is active
            if ($user->isAuthenticated() && $user->getAttribute('status_id') != MemberStatusPeer::ACTIVE && ($module . '/' . $action) != 'content/message' && $module != 'ajax')
            {
                $AI = $this->getContext()->getActionStack()->getLastEntry()->getActionInstance();
                switch ($user->getAttribute('status_id')) {
                    case MemberStatusPeer::ABANDONED:
                        if ($module != 'registration' && $module != 'IMBRA' )
                        {
                            $member = $context->getUser()->getProfile();
                            //take decision on witch step is the registration procces
                            if (! $member->getFirstName()) //1. Step 1 - registration
                            {
                                $url = 'registration/index';
                            } elseif (! $member->getBirthDay()) //2. Step 2 - self description 
                            {
                                $url = 'registration/selfDescription';
                            } elseif (! $member->getEssayHeadline()) //3. Step - essay 
                            {
                                $url = 'registration/essay';
                                /* Non required now
                            } elseif ($member->countMemberPhotos() <= 0) //Step 4 - Photos
                            {
                                $url = 'registration/photos';
                            */
                            } elseif ( $member->mustFillIMBRA() ) //Step 5 - IMBRA (if US citizen)
                            {
                                $url = 'IMBRA/index';
                            } else {
                                throw new sfException('Unknown registration step');
                            }
                            //set message and redirect
                            if (isset(
                                    $url))
                            {
                                sfLoader::loadHelpers(array('Url'));
                                $AI->setFlash('s_title', 'Complete Registration');
                                $AI->setFlash('s_msg', 
                                        'Welcome back. You may finish your registration <a href="{REGISTRATION_URL}" class="sec_link">here</a>.');
                                $AI->setFlash('s_vars', 
                                        array('{REGISTRATION_URL}' => url_for(
                                                $url)));
                                $AI->redirect('content/message');
                            }
                        }
                        break;
                    case MemberStatusPeer::CANCELED:
                        sfLoader::loadHelpers(array('Url'));
                        $AI->setFlash('s_title', 'Sorry');
                        $AI->setFlash('s_msg', 
                                'Sorry, your account has been removed by website administration due to the violation of our <a href="{USER_AGREEMENT_URL}" class="sec_link">Terms of Use</a> (spamming, scamming, suspicious activities, use of a stolen credit card, harassing other 
                                     members, advertising other services, or other abuses). If you were a paid member, you will not be 
                                     charged again. If you believe your suspension is a mistake, please <a href="{CONTACT_US_URL}" class="sec_link">contact us</a>.');
                        $AI->setFlash('s_vars', 
                                array('{USER_AGREEMENT_URL}' => url_for(
                                        '@page?slug=user_agreement'), '{CONTACT_US_URL}' => url_for(
                                        '@page?slug=contact_us')));
                        $AI->redirect('content/message');
                        break;
                    case MemberStatusPeer::SUSPENDED:
                        sfLoader::loadHelpers(array('Url'));
                        $AI->setFlash('s_title', 'Sorry');
                        $AI->setFlash('s_msg', 
                                'Sorry, your account has been suspended by website administration due to the violation of our <a href="{USER_AGREEMENT_URL}" class="sec_link">Terms of Use</a> (spamming, scamming, suspicious activities, use of a stolen credit card, harassing other 
                                    members, advertising other services, or other abuses). We will contact you by email to let you know if you can still user our website.');
                        $AI->setFlash('s_vars', 
                                array('{USER_AGREEMENT_URL}' => url_for(
                                        '@page?slug=user_agreement')));
                        $AI->redirect('content/message');
                        break;
                    case MemberStatusPeer::FLAGGED:
                        $AI->setFlash('s_title', 'Sorry');
                        $AI->setFlash('s_msg', 
                                'Your account has been reported by other members (flagged) and is currently under review by website 
                                administrator. Usually review is done within 24 hours from suspension, so please try to sign in 
                                tomorrow to check your status.');
                        $AI->redirect('content/message');
                        break;
                    case MemberStatusPeer::PENDING:
                        $AI->setFlash('s_title', 'Congratulations, your registration is complete.');
                        $AI->setFlash('s_msg', 'Congratulations, your registration is complete. Your profile will be reviewed 
                                                and we will let you know if you\'re approved within the next 24 hours - please look out for our email.');
                        $AI->redirect('content/message');
                        break;
                    case MemberStatusPeer::DENIED:
                        $AI->setFlash('s_title', 'Sorry');
                        $AI->setFlash('s_msg', 'You registration has been denied.');
                        $AI->redirect('content/message');
                        break;
                    case MemberStatusPeer::CANCELED_BY_MEMBER:
                        break;
                    default:
                        break;
                }
            }
            //$request = $this->getContext()->getRequest();
        //$response = $this->getContext()->getResponse();
        }
        $filterChain->execute();
    }
}

