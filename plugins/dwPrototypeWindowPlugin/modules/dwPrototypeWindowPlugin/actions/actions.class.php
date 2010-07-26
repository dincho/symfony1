<?php

/**
 * sfPrototypeWindowPlugin actions.
 *
 * @package    symfony
 * @subpackage dwPrototypeWindowPlugin
 * @author     Dustin Whittle <dustin.whittle@symfony-project.com>
 * @author     Vernet Loic aka COil <qrf_coil[at]yahoo[dot]fr>
 */
class dwPrototypeWindowPluginActions extends sfActions
{

  /**
   * index action
   *
   * @see executeTest()
   */
  public function executeIndex()
  {
    $this->forward($this->getModuleName(), 'test');
  }

  /**
   * Test of sfPrototypeWindowPlugin
   */
  public function executeTest()
  {
		return sfView::SUCCESS;
  }

 /**
  * Executes executeContent action
  */
  public function executeContent()
  {
		return sfView::SUCCESS;
  }

 /**
  * Executes executeexemple1Conten action
  */
  public function executeExample1Content()
  {
		return sfView::SUCCESS;
  }


}