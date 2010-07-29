<?php
/**
 * sfOptimizeStyleAndScript
 *
 * 
 * @package    sfOptimizeStyleAndScript
 * @subpackage Filter
 * @author     Michel Meyer <mmeyer68@wanadoo.fr>
 * @comment    Merge and compress stylesheets and javascripts files. Cache them in the http web dir
 */
class sfOptimizeStyleAndScript extends sfFilter
{

  private
  $content = array('javascript' => '',
           'stylesheet' => '');


  /**
   * Executes this filter.
   *
   * @param sfFilterChain A sfFilterChain instance
   */
  public function execute($filterChain)
  {
    // execute next filter
    $filterChain->execute();

    // execute this filter only once
    $response = $this->getContext()->getResponse();

    // include javascripts and stylesheets
    $content = $response->getContent();
    if (false !== ($pos = strpos($content, '</head>')))
    {
      sfLoader::loadHelpers(array('Tag', 'Asset', 'Javascript'));
      $html = '';
      if (!$response->getParameter('javascripts_included', false, 'symfony/view/asset'))
      {
        $html .= $this->mergeJavascriptsFiles($response);
      }
      if (!$response->getParameter('stylesheets_included', false, 'symfony/view/asset'))
      {
        $html .= $this->mergeStylesheetsFiles($response);
      }

      if ($html)
      {
        $response->setContent(substr($content, 0, $pos).$html.substr($content, $pos));
      }
    }

    $response->setParameter('javascripts_included', false, 'symfony/view/asset');
    $response->setParameter('stylesheets_included', false, 'symfony/view/asset');
  }

  /**
   * Merge all javascripts files, write the result in one js file on http web dir
   *
   * @param  sfWebResponse $response
   * @return string        javascript tag
   */
  public function mergeJavascriptsFiles($response){

    $response->setParameter('javascripts_included', true, 'symfony/view/asset');
    $already_seen = array();
    $remote_files = array();
    $ret = '';
    
    $javascripts_files = $response->getParameterHolder()->getAll('helper/asset/auto/javascript');

    foreach ($javascripts_files as $key => $value) {
      if( strpos($value, 'http://') !== false )
      {
        $remote_files[] = $value;
        unset($javascripts_files[$key]);
      }
    }
    
    $encoded_name      = $this->makeMd5($javascripts_files);

    //cache test (in cache for one day by default)
    if($include_file = $this->getCachedFile($encoded_name, '.js', sfConfig::get('sf_optimizer_js_lifetime', 86400)))
    {
      foreach($remote_files as $remote_file) $ret .= javascript_include_tag($remote_file);
      $ret .= javascript_include_tag($include_file);
      
      return $ret;      
    }

    foreach (array('first', '', 'last') as $position)
    {
      foreach ($response->getJavascripts($position) as $files)
      {
        if (!is_array($files))
        {
          $files = array($files);
        }


        foreach($files as $file)
        {
          if( strpos($file, 'http://') !== false ) continue; //skip remote files
          
          $file  = javascript_path($file);

          if (isset($already_seen[$file])) continue;

          $already_seen[$file] = 1;

          $this->content['javascript'] .= "\n\n".'/* include js file: '.$file." */\n\n";
          
          if(false === ($this->content['javascript'] .= file_get_contents(sfConfig::get('sf_web_dir').$file)))
          throw new sfFileException('Can not open '.sfConfig::get('sf_web_dir').$file.' for merging');
        }
      }
    }

    // compress js code
    if(sfConfig::get('sf_optimizer_js_compressed', false))
    {
      $this->content['javascript'] = JSMin::minify($this->content['javascript']);
    }
    
    if($file = $this->saveFile($encoded_name.'_'.time().'.js', 'javascript'))
    {
      foreach($remote_files as $remote_file) $ret .= javascript_include_tag($remote_file);
      $ret .= javascript_include_tag($file);
      
      return $ret;
    }
    else 
    {
      return false;
    }
  }

  /**
   * Merge all javascripts files, write the result in one js file on http web dir
   *
   * @param  sfWebResponse $response
   * @return string        stylesheet link tag
   */
  public function mergeStylesheetsFiles($response){

    $response->setParameter('stylesheets_included', true, 'symfony/view/asset');
    $already_seen = array();

    $stylesheets_files = $response->getParameterHolder()->getAll('helper/asset/auto/stylesheet');
    $encoded_name      = $this->makeMd5($stylesheets_files);

    //cache test (in cache for one day by default)
    if($include_file = $this->getCachedFile($encoded_name,  '.css', sfConfig::get('sf_optimizer_css_lifetime', 86400)))
    {
      return stylesheet_tag($include_file);
    }

    foreach (array('first', '', 'last') as $position)
    {
      foreach ($response->getStylesheets($position) as $files => $options)
      {
        if (!is_array($files))
        {
          $files = array($files);
        }

        foreach ($files as $file)
        {
          $file  = stylesheet_path($file);

          if (isset($already_seen[$file])) continue;

          $already_seen[$file] = 1;

          $this->content['stylesheet'] .= "\n\n".'/* include css file: '.$file." */\n\n";
          $this->content['stylesheet'] .= $this->getStyleConent($file);
        }
      }
    }


    // compress css code
    if(sfConfig::get('sf_optimizer_css_compressed', false))
    {
      $this->content['stylesheet'] = cssmin::minify($this->content['stylesheet'], array('preserve-urls' => false));
    }
    

    if($file = $this->saveFile($encoded_name.'_'.time().'.css', 'stylesheet'))
    {
      return stylesheet_tag($file);
    }
    else 
    {
      return null;
    }
  }

  /**
   * Save content on http web dir
   *
   * @param  string $file_name
   * @param  string $type          self:content array keys
   * @return string                http file uri
   */
  private function saveFile($file_name, $type){
    
    if(isset($this->content[$type])) {

      
      
      if(!is_dir(sfConfig::get('sf_web_dir').'/'.sfConfig::get('sf_optimizer_dir','cache')))
      {
        mkdir(sfConfig::get('sf_web_dir').'/'.sfConfig::get('sf_optimizer_dir','cache'),0755,true);
      }
        
      $file = sfConfig::get('sf_web_dir').'/'.sfConfig::get('sf_optimizer_dir','cache').'/'.$file_name;

      if(false === file_put_contents($file,$this->content[$type]))
      {
        throw new sfFileException('Can not create merged '.$type.' file in '.$file);
      }
      
      return '/'.sfConfig::get('sf_optimizer_dir','cache').'/'.$file_name;
    }
    return false;
  }

  private function getStyleConent($file)
  {
        return file_get_contents(sfConfig::get('sf_web_dir').$file);      
  }
  /**
   * Redefine the url() properties for css (because the css file has a new position)
   *
   * @param  string  $file   original css file path
   * @return string          new css content
   */
  private function getStyleContentWithNewBgUrl($file){

      
    chdir(sfConfig::get('sf_web_dir'));

    $rootdir = realpath(sfConfig::get('sf_web_dir'));
    $content = '';

    eregi("^(.*)/(.*)$",$file, $captured_filepath);
      
    
    if(!$content_lines = @file(sfConfig::get('sf_web_dir').$file))
    {
      throw new sfFileException('Can not open '.$file.' for merging');
    }
    
    foreach($content_lines as $content_line)
    {
        
      $captured_image = null;
      $replace        = null;
        
      eregi("url[ ]*\((.*)\)",$content_line, $captured_image);
        
        
      if(!empty($captured_image))
      {
        $image_path = $captured_filepath[1].'/'.$captured_image[1];

        $img        = realpath($rootdir.$image_path);
        $image_path = str_replace($rootdir,'',$img);
        $image_path = str_replace('\\','/',$image_path);

        $replace     = eregi_replace("url[ ]*\(.*\)",'url('.$image_path.')',$content_line);
      }
        
      $content .= !empty($replace) ? $replace : $content_line;
    }
    return $content;
  }


  /**
   * Calculate a md5 name composed with all files path
   *
   * @param  array   $files  list of all file path
   * @return string
   */
  private function makeMd5($files){
    $name = '';

    if(!is_array($files))
    {
      $files = array($files);
    }

    foreach($files as $file)
    {
      $name .= $file;
    }

    return md5($name);
  }

  
  /**
   * Check and retrieve the cache file uri usable by symfony helper
   *
   * @param  string      $encoded_name   filename in md5
   * @param  string      $extension      extension with dot
   * @param  int         $lifetime       lifetime of cache file in second
   * @return string|bool                 if not in cache, false, else cache file uri usable by symfony helper
   */
  private function getCachedFile($encoded_name, $extension, $lifetime = 0){

    $path        = sfConfig::get('sf_web_dir').'/'.sfConfig::get('sf_optimizer_dir','cache').'/';
    $seemslike   = glob($path.$encoded_name.'_*'.$extension);


    foreach($seemslike as $url){
      eregi('^.*[\\|/]([0-9a-z]*)_([0-9]*)(\..*)$',$url,$captured);
      $file_indentifier = $captured[1];
      $file_timestamp   = $captured[2];
      $file_extension   = $captured[3];
        
      //check if file realy seem like, optional peraps ...
      if($file_indentifier == $encoded_name && $file_extension == $extension)
      {
        //refresh cached file
        if((time() - $file_timestamp) > $lifetime)
        {
          if(false === unlink($url))
          throw new sfFileException('Unable to delete cache file: '.$url);
        }
        else
        {
          return '/'.sfConfig::get('sf_optimizer_dir','cache').'/'.$file_indentifier.'_'.$file_timestamp.$file_extension;
        }
      }
    }
    return false;
  }
}



