<?php
/*
 * example element array('name' => 'home', 'uri' => 'content/home')
 */
class prFrontendBreadCrumb extends xBreadcrumb
{
  private static $instance = null;
  private $delim = ' > '; //escaped in the View
  private $class = 'breadcrumb';
  private $tr_last = true;
  private $custom_bc;

  protected function __construct()
  {
    parent::__construct();
    $context = sfContext::getInstance();
    $module = $context->getModuleName();
    $action = $context->getActionName();

    $this->add(array('name' => $module, 'uri' => $module . '/index'));
    //$this->add(array('name' => 'Home', 'uri' => '@homepage'));
    if( $action != 'index' ) $this->add(array('name' => $action, 'uri' => $module . '/' . $action));
  }

  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      $class_name = get_class();
      self::$instance = new $class_name;
    }

    return self::$instance;
  }

  public function getLastName()
  {
      sfLoader::loadHelpers(array('I18N'));

      $el = $this->getLast();

      return ( $this->tr_last ) ? __($this->humanize($el['name'])) : $this->humanize($el['name']);
  }

  public function humanize($string)
  {
    $tmp = $string;

    if ( strpos($string, ' ') === false ) {
        $tmp = str_replace('::', '/', $tmp);
        $tmp = sfToolkit::pregtr($tmp, array('/([A-Z]+)([A-Z][a-z])/' => '\\1 \\2',
                                             '/([a-z\d])([A-Z])/'     => '\\1 \\2'));

        $tmp = strtolower($tmp);
        $tmp = ucwords($tmp);
    }

    return $tmp;
  }

  public function dontTrLast()
  {
      $this->tr_last = false;

      return $this;
  }

    public function isLastItemTranslatable()
    {
        return $this->tr_last;
    }

    public function getStack()
    {
        //add header_title slot as last element if exists
        $slots = sfContext::getInstance()->getResponse()->getParameter('slots', array(), 'symfony/view/sfView/slot');

        if ( isset($slots['header_title']) ) {
            $this->add(array('name' => trim($slots['header_title'])));
            $this->tr_last = false;
        }

        return parent::getStack();
    }

    public function getDelimiter()
    {
        return $this->delim;
    }

    public function getElementName($index)
    {
        $el = $this->getElement($index);

        return (isset($el['name'])) ? $this->humanize($el['name']) : null;
    }

    public function setCustomLastItem($value)
    {
        $this->custom_bc = $value;

    }

    public function getCustomLastItem()
    {
        return $this->custom_bc;
    }
}
