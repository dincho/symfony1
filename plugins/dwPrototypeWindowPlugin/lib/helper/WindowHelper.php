<?php

use_helper('Javascript');

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Dustin Whittle <dustin.whittle@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    symfony
 * @subpackage dwPrototypeWindowPlugin
 * @author     Dustin Whittle <dustin.whittle@symfony-project.com>
 * @version    SVN: $Id$
 */

/**
 * link_to_prototype_dialog creates a dialog box using prototype.
 *
 *
 * Example:
 * <code>
 *   <?php use_helper('Window'); ?>
 *   <?php if(sfConfig::get('sf_debug')) { echo link_to_function('open debug window', 'showDebug()'); } ?>
 *   <?php echo link_to_prototype_dialog('hello', 'hello world', 'alert', array('className' => 'alphacube')); ?>
 * </code>
 *
 * @link http://prototype-window.xilinus.com/documentation.html#initialize
 *
 * @param string $name
 * @param string $content
 * @param string $dialog_type 'alert' (default), 'confirm' or 'info' (info dialogs should be destroyed with a javascript function call 'win.destroy')
 * @param array $options for this helper depending the dialog_kind: http://prototype-window.xilinus.com/documentation.html#alert (#confirm or #info)
 * @param array $options_html
 * @return string
 */
function link_to_prototype_dialog($name, $content, $dialog_type = 'alert', $options = array(), $options_html = array())
{
 /**
	* @todo to get from config default options
	* $window_options = array_merge(array('title' => 'New Dialog', 'className' => 'dialog', 'width' => '200', 'height' => '100', 'zIndex' => '100', 'draggable' => 'true', 'resizable' => 'true', 'opacity' => 1, 'showEffect' => 'Effect.BlindDown', 'hideEffect' => 'Effect.SwitchOff'), _parse_attributes($window_options));
	*/

  _add_prototype_window_assets($options);

  $options = _parse_attributes($options);

  // Convert string options
  $string_options = array('title', 'className', 'okLabel', 'buttonClass', 'id');
  $options = _convert_string_options($options, $string_options);

  // Add debug
  $options = _add_debug($options);

  $js_code = 'Dialog.'. $dialog_type. '(\''. escape_javascript($content). '\', '. _options_for_javascript($options). ');';

  $options_html = _parse_attributes($options_html);
  $options_html['href'] = isset($options_html['href']) ? $options_html['href'] : '#';
  $options_html['onclick'] = isset($options_html['onclick']) ? $options_html['onclick'] . $js_code : $js_code;

  return content_tag('a', $name, $options_html);
}

/**
 * link_to_prototype_window creates a window using prototype.
 *
 * Example:
 * <code>
 *   <?php use_helper('Window'); ?>
 *   <?php if(sfConfig::get('sf_debug')) { echo link_to_function('open debug window', 'showDebug()'); } ?>
 *   <?php echo link_to_prototype_window('Google', 'google', array('title' => 'Google', 'url' => 'http://google.com', 'width' => '520', 'height' => '350', 'center' => 'true', 'className' => 'alphacube'), array('absolute' => true)); ?>
 *   <?php echo link_to_prototype_window('DW', 'dw', array('title' => 'DW', 'url' => '@homepage', 'width' => '520', 'height' => '350', 'center' => 'true', 'className' => 'alphacube')); ?>
 * </code>
 *
 * @link http://prototype-window.xilinus.com/documentation.html#initialize
 *
 * @param string $name
 * @param string $window_id must be unique and it's destroyed on window close.
 * @param array $options options for this helper: http://prototype-window.xilinus.com/documentation.html#initialize
 * @param array $options_html
 * @return string
 */
function link_to_prototype_window($name, $window_id, $options, $options_html = array())
{
  /**
	 * @todo to get from config default options
	 * $options = array_merge(array('title' => 'New Window', 'className' => 'dialog', 'width' => '600', 'height' => '450', 'zIndex' => '100', 'draggable' => 'true', 'resizable' => 'true', 'opacity' => 1, 'showEffect' => 'Effect.BlindDown', 'hideEffect' => 'Effect.SwitchOff'), _parse_attributes($options));
	 */

  _add_prototype_window_assets($options);

  // Convert string options
  $string_options = array('title', 'className');
  $options = _convert_string_options($options, $string_options);

  if (isset($options['url']))
  {
    $options['url'] = _method_option_to_s(url_for($options['url'], isset($options_html['absolute']) ? true : false));
  }
  unset($options_html['absolute']);

  $front = isset($options['front']) ? $window_id.'.toFront();' : '';
  unset($options['front']);

  $status = isset($options['status']) ? $window_id.'.setStatusBar(\''.$options['status'].'\');' : '';
  unset($options['status']);

  $show = isset($options['center']) ? $window_id.'.showCenter();' : $window_id.'.show();';
  unset($options['center']);

  $destroy = $window_id. '.setDestroyOnClose();';
  $options = _options_for_javascript($options);
  $options_html = _parse_attributes($options_html);

  $js_code = 'var ' . $window_id . ' = new Window('. $options.');'. $front. $status. $show. $destroy;
  $js_code = 'var ' . $window_id . ' = new Window('. $options.');'.$front. $status. $show. $destroy.' return false;';

  $options_html['href'] = isset($options_html['href']) ? $options_html['href'] : '#';
  $options_html['onclick'] = isset($options_html['onclick']) ? $options_html['onclick'] . $js_code : $js_code;

  return content_tag('a', $name, $options_html);
}

/**
 * link_to_prototype_window creates a window from content from the page using
 * prototype.
 *
 * @link http://prototype-window.xilinus.com/documentation.html#initialize
 *
 * @param string $name
 * @param string $window_id must be unique and it's destroyed on window close.
 * @param
 * @param array $options options for this helper: http://prototype-window.xilinus.com/documentation.html#initialize
 * @param array $options_html
 * @return string
 */
function link_to_prototype_window_from_content($name, $window_id, $content_id, $options, $options_html = array())
{
  _add_prototype_window_assets($options);

  // convert string options
  $string_options = array('title', 'className');
  $options = _convert_string_options($options, $string_options);

  $set_content = $window_id. '.setContent(\''. $content_id. '\', true, true);';
  $show = $window_id. '.show();';
  $destroy = $window_id. '.setDestroyOnClose();';

  $options = _options_for_javascript($options);
  $options_html = _parse_attributes($options_html);

  $js_code = 'var '. $window_id. ' = new Window('. $options.');'. $set_content. $show. $destroy;

  $options_html['href'] = isset($options_html['href']) ? $options_html['href'] : '#';
  $options_html['onclick'] = isset($options_html['onclick']) ? $options_html['onclick'] . $js_code : $js_code;

  return content_tag('a', $name, $options_html);
}

/**
 * Return a link to a debug prototype window
 *
 * @author COil
 */
function link_to_prototype_debug($name)
{
  if(sfConfig::get('sf_debug'))
  {
    return link_to_function($name, 'showDebug()');
  }
}

/**
 * Add plugin specific resources
 *
 * @author COil
 */
function _add_prototype_window_assets($options)
{
  $default_classname_style = array('dialog');

  $request = sfContext::getInstance()->getResponse();

  $sf_prototype_web_dir = sfConfig::get('sf_prototype_web_dir');
  $sf_prototype_window_web_dir = sfConfig::get('sf_prototype_window_web_dir', '/dwPrototypeWindowPlugin');

  // prototype
  $request->addJavascript($sf_prototype_web_dir. '/js/prototype');
  $request->addJavascript($sf_prototype_web_dir. '/js/effects');

  // window
  $request->addJavascript($sf_prototype_window_web_dir.'/js/window');
  $request->addJavascript($sf_prototype_window_web_dir.'/js/window_ext');

  $request->addStylesheet($sf_prototype_window_web_dir.'/themes/default.css');

  if(isset($options['className']) && (!in_array($options['className'], $default_classname_style)))
  {
    $request->addStylesheet($sf_prototype_window_web_dir. '/themes/'. $options['className'].'.css');
  }

  if(sfConfig::get('sf_debug'))
  {
    $request->addJavascript($sf_prototype_window_web_dir. '/js/debug');
    $request->addJavascript($sf_prototype_window_web_dir. '/js/extended_debug');
  }

}

/**
 * Convert all options that need to be quoted
 *
 * @author COil
 *
 * @param array $options Options to check
 * @param array $string_options Keys of options array that need to be qupted
 */
function _convert_string_options($options, $string_options)
{
  if ($string_options)
  {
    foreach ($string_options as $option)
    {
      if (isset($options[$option]))
      {
        $options[$option] = _method_option_to_s($options[$option]);
      }
    }
  }
  return $options;
}

/**
 * Add debug informations
 *
 * @todo : Debug should be be mapped on the ok function, to check
 *
 * @author COil
 */
function _add_debug($options)
{
  if (isset($options['debug']))
  {
    $options['ok'] = isset($options['debug']) ? 'function(win) { debug(\''. $options['debug']. '\'); return true; }' : '';
    unset($options['debug']);
  }

  return $options;
}

