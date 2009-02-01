<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * I18NHelper.
 *
 * @package    symfony
 * @subpackage helper
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @author     Dincho Todorov <dincho@xbuv.com>
 * @version    SVN: $Id: I18NHelper.php 5141 2007-09-16 14:37:58Z fabien $
 */

function getParserUrls()
{
    $con = sfContext::getInstance()->getController();
    $ret = array('%URL_FOR_DASHBOARD%' => $con->genUrl('@dashboard'),
                 '%URL_FOR_SEARCH%' => $con->genUrl('@matches'),
                 '%URL_FOR_MESSAGES%' => $con->genUrl('messages/index'),
                 '%URL_FOR_MEMBER_STORIES%' => $con->genUrl('@member_stories'),
                 '%URL_FOR_REPORT_BUG%' => $con->genUrl('content/reportBug'),
                 '%URL_FOR_CONTACT_ASSISTANT%' => $con->genUrl('dashboard/contactYourAssistant'),
                 '%URL_FOR_WINKS%' => $con->genUrl('@winks'),
                 '%URL_FOR_HOTLIST%' => $con->genUrl('@hotlist'),
                 '%URL_FOR_VISITORS%' => $con->genUrl('@visitors'),
                 '%URL_FOR_BLOCKS%' => $con->genUrl('@blocked_members'),
                 '%URL_FOR_SIGNIN%' => $con->genUrl('@signin'),
                 '%URL_FOR_SIGNOUT%' => $con->genUrl('@signout'),
                 '%URL_FOR_REGISTRATION%' => $con->genUrl('editProfile/registration'),
                 '%URL_FOR_SELF_DESCRIPTION%' => $con->genUrl('editProfile/selfDescription'),
                 '%URL_FOR_SEARCH_CRITERIA%' => $con->genUrl('dashboard/searchCriteria'),
                 '%URL_FOR_ESSAY%' => $con->genUrl('editProfile/essay'),
                 '%URL_FOR_PHOTOS%' => $con->genUrl('editProfile/photos'),
                 '%URL_FOR_IMBRA%' => $con->genUrl('imbra/index'),
                 '%URL_FOR_SUBSCRIPTION%' => $con->genUrl('subscription/index'),
                 '%URL_FOR_HOMEPAGE%' => $con->genUrl('@homepage'),
                 '%URL_FOR_JOIN_NOW%' => $con->genUrl('registration/joinNow'),
                 '%URL_FOR_MY_PROFILE%' => $con->genUrl('profile/myProfile'),
                 '%URL_FOR_DEACTIVATE_PROFILE%' => $con->genUrl('dashboard/deactivate'),
                 '%URL_FOR_EMAIL_NOTIFICATIONS%' => $con->genUrl('dashboard/emailNotifications'),
                 '%URL_FOR_PRIVACY%' => $con->genUrl('dashboard/privacy'),
                 '%URL_FOR_DELETE_ACCOUNT%' => $con->genUrl('dashboard/deleteYourAccount'),
                 '%URL_FOR_HOW_IT_WORKS%' => $con->genUrl('@page?slug=how_it_works'),
                 '%URL_FOR_ABOUT_US%' => $con->genUrl('@page?slug=about_us'),
                 '%URL_FOR_HELP%' => $con->genUrl('@page?slug=help'),
                 '%URL_FOR_SEARCH_ENGINES%' => $con->genUrl('@search_engines'),
                 '%URL_FOR_TERMS%' => $con->genUrl('@page?slug=user_agreement'),
                 '%URL_FOR_PRIVACY_POLICY%' => $con->genUrl('@page?slug=privacy_policy'),
                 '%URL_FOR_IMBRA_INFO%' => $con->genUrl('@page?slug=imbra'),
                 '%URL_FOR_LEGAL%' => $con->genUrl('@page?slug=for_law_enforcement'),
                 '%URL_FOR_SITE_MAP%' => $con->genUrl('@page?slug=site_map'),
                 '%URL_FOR_FAQ%' => $con->genUrl('@page?slug=frequently_asked_questions'),
                 '%URL_FOR_CONTACT_US%' => $con->genUrl('@page?slug=contact_us'),
                 '%URL_FOR_AFFILIATES%' => $con->genUrl('@page?slug=affiliates'),
                 '%URL_FOR_TELL_FRIEND%' => $con->genUrl('content/tellFriend'),
                 '%URL_FOR_COPYRIGHT%' => $con->genUrl('@page?slug=copyright'),
                 '%URL_FOR_SAFETY_TIPS%' => $con->genUrl('@page?slug=safety_tips'),
                 '%URL_FOR_LEGAL_RESOURCES%' => $con->genUrl('@page?slug=legal_resources'),
                 '%URL_FOR_IMMIGRANT_RIGHTS%' => $con->genUrl('@page?slug=immigrant_rights'),
                );    
                
    return $ret;
}


function __($text, $args = array(), $catalogue = 'messages')
{
  static $i18n;

  $args = array_merge($args, getParserUrls());
  
  if (sfConfig::get('sf_i18n'))
  {
    if (!isset($i18n))
    {
      $i18n = sfContext::getInstance()->getI18N();
    }

    return $i18n->__($text, $args, $catalogue);
  }
  else
  {
    if (empty($args))
    {
      $args = array();
    }

    // replace object with strings
    foreach ($args as $key => $value)
    {
      if (is_object($value) && method_exists($value, '__toString'))
      {
        $args[$key] = $value->__toString();
      }
    }

    return strtr($text, $args);
  }
}

function format_number_choice($text, $args = array(), $number, $catalogue = 'messages')
{
  $translated = __($text, $args, $catalogue);

  $choice = new sfChoiceFormat();

  $retval = $choice->format($translated, $number);

  if ($retval === false)
  {
    $error = sprintf('Unable to parse your choice "%s"', $translated);
    throw new sfException($error);
  }

  return $retval;
}

function format_country($country_iso, $culture = null)
{
  $c = new sfCultureInfo($culture === null ? sfContext::getInstance()->getUser()->getCulture() : $culture);
  $countries = $c->getCountries();

  return isset($countries[$country_iso]) ? $countries[$country_iso] : '';
}

function format_language($language_iso, $culture = null)
{
  $c = new sfCultureInfo($culture === null ? sfContext::getInstance()->getUser()->getCulture() : $culture);
  $languages = $c->getLanguages();

  return isset($languages[$language_iso]) ? $languages[$language_iso] : '';
}
