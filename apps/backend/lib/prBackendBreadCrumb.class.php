<?php
/*
 * example element array('name' => 'home', 'uri' => 'content/home')
 */
class prBackendBreadCrumb extends xBreadcrumb
{
  private static $instance = null;
  private $delim = '&nbsp;&gt;&nbsp;';
  private $class = 'breadcrumb';

  protected function __construct()
  {
    parent::__construct();
    $context = sfContext::getInstance();
    $module = $context->getModuleName();
    $action = $context->getActionName();

    $this->add(array('name' => $module, 'uri' => $module . '/list'));
    $this->add(array('name' => $action, 'uri' => $module . '/' . $action));
  }

  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      $class_name = get_class();
      self::$instance = new $class_name;
    }

    return self::$instance;
  }

  public function draw()
  {
    $content = '';

    $stack = $this->getStack();
    $cnt = count($stack)-1; //do not add link to last element

    for ($i=0; $i<$cnt; $i++) {
      $content .= link_to(ucfirst($stack[$i]['name']), $stack[$i]['uri']) . $this->delim;
    }

    //add last element manual, just text not a link
    $content .= ucfirst($stack[$i++]['name']);

    //at least, draw the breadcrumb content
    //echo content_tag('div', $content, array('class' => $this->class));
    echo $content;
  }

}
