<?php
/**
 * Breadcrumb menu class
 * 
 * @author Dincho Todorov <dincho@xbuv.com>
 * @copyright Copyright (c) 2008, Dincho Todorov
 *
 * @package xLib
 * @version 1.0
 *
 */
class xBreadcrumb
{
  private static $instance = null;
  private $stack = array();
  
  protected function __construct()
  {
    
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
  
  public function addFirst($element)
  {
    array_unshift($this->stack, $element);
    
    return $this;
  }
  
  public function removeFirst()
  {
    array_shift($this->stack);
    
    return $this;
  }
  
  public function replaceFirst($element)
  {
    $this->removeFirst();
    $this->addFirst($element);
    
    return $this;
  }
  
  public function addAfterFirst($element)
  {
    $tmp = array_shift($this->stack);
    array_unshift($this->stack, $tmp, $element);
    
    return $this;
  }
  
  public function addLast($element)
  {
    array_push($this->stack, $element);
    
    return $this;
  }
  
  public function removeLast()
  {
    array_pop($this->stack);
    
    return $this;
  }
  
  public function replaceLast($element)
  {
    $this->removeLast();
    $this->add($element);
    
    return $this;
  }
  
  //just a proxy to addLast method ( default add position )
  public function add($element)
  {
    return $this->addLast($element);
  }
  
  public function addBeforeLast($element)
  {
    $tmp = array_pop($this->stack);
    array_push($this->stack, $element, $tmp);
    
    return $this;
  }
  
  public function addToPos($element, $pos = 1)
  {
    $pos--; //human readble numbers
    
    $tmp = array_slice($this->stack, 0, $pos);
    $tmp1 = array_slice($this->stack, $pos);
    array_push($tmp, $element);
    
    $this->stack = array_merge($tmp, $tmp1);
    
    return $this;
  }
  
  public function getStack()
  {
    return $this->stack;
  }
  
  public function getLast()
  {
      return $this->stack[count($this->stack)-1];
  }
  
  public function clear()
  {
    $this->stack = array();
    
    return $this;
  }
  
  public function __destruct()
  {
    unset($this->stack);
  }
}
?>