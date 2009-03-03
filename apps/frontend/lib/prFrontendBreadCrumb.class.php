<?php
/*
 * example element array('name' => 'home', 'uri' => 'content/home')
 */
class prFrontendBreadCrumb extends xBreadcrumb 
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
    
    $this->add(array('name' => $module, 'uri' => $module . '/index'));
    //$this->add(array('name' => 'Home', 'uri' => '@homepage'));
    if( $action != 'index' ) $this->add(array('name' => $action, 'uri' => $module . '/' . $action));
  }
  
  public static function getInstance()
  {
    if (is_null(self::$instance))
    {
      $class_name = get_class();
      self::$instance = new $class_name;
    }
    
    return self::$instance;
  }
  
  public function getLastName()
  {
      $el = $this->getLast();
      return $this->humanize($el['name']);
  }
  
  public function draw()
  {
    $content = '';
    
    $stack = $this->getStack();
    $cnt = count($stack)-1; //do not add link to last element
    sfLoader::loadHelpers(array('I18N'));
    
    for( $i=0; $i<$cnt; $i++ )
    {
      $name = $this->humanize($stack[$i]['name']);
      
      if( isset($stack[$i]['uri']) )
      {
        $content .= link_to(__($name), $stack[$i]['uri']) . $this->delim;
      } else {
        $content .= __($name) . $this->delim;
      }
    }
    
    //add last element manual, just text not a link
    $content .= __($this->humanize($stack[$i++]['name']));
    
    //at least, draw the breadcrumb content
    //echo content_tag('div', $content, array('class' => $this->class));
    echo $content;
  }
  
  public function humanize($string)
  {
    $tmp = $string;
    $tmp = str_replace('::', '/', $tmp);
    $tmp = sfToolkit::pregtr($tmp, array('/([A-Z]+)([A-Z][a-z])/' => '\\1 \\2',
                                         '/([a-z\d])([A-Z])/'     => '\\1 \\2'));

    $tmp = strtolower($tmp);
      	
  	return ucwords($tmp);
  }
    
}
?>