<?php
class prTestBrowser extends sfTestBrowser
{
  public function initialize($hostname = 'www.polishdate.com', $remote = null, $options = array())
  {
    parent::initialize($hostname, $remote, $options);
  }
}