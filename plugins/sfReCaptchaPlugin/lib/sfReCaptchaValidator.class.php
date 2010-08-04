<?php

/**
 * Verifies the response.
 *
 * @package    symfony
 * @subpackage sfReCaptchaValidator
 * @author     Arthur Koziel <arthur@arthurkoziel.com>
 * @version    SVN: $Id$
 */
class sfReCaptchaValidator extends sfValidator
{
  /**
   * Execute this validator.
   *
   * @param mixed A file or parameter value/array
   * @param error An error message reference
   *
   * @return bool true, if this validator executes successfully, otherwise false
   */
  public function execute(&$value, &$error)
  {
    // get values of challange and response fields
    $request = $this->getContext()->getRequest();
    
    $challenge = $request->getParameter('recaptcha_challenge_field');
    $response  = $request->getParameter('recaptcha_response_field');

    // validate the given response against the challenge
    $recaptcha_keys = sfConfig::get('app_recaptcha_' . str_replace('.', '_', $request->getHost()));
    $resp = recaptcha_check_answer ($recaptcha_keys['privatekey'],
                                    $_SERVER["REMOTE_ADDR"],
                                    $challenge,
                                    $response);

    // if invalid, return error
    if (!$resp->is_valid)
    {
      $error = $resp->error;

      return false;
    }

    return true;
  }

  /**
   * Initializes the validator.
   *
   * @param sfContext The current application context
   * @param array   An associative array of initialization parameters
   *
   * @return bool true, if initialization completes successfully, otherwise false
   */
  public function initialize($context, $parameters = null)
  {
    require ('recaptchalib.php');
    
    parent::initialize($context);

    return true;
  }
}
