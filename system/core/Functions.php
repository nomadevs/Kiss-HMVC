<?php
/**
 * Functions
 *  
 * Helper functions with global scope used by core files
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Global Functions
 * @author      nomadevs
 * @link        https://mywebfolio.me/
 * @copyright   Copyright (c) 2020, nomadevs, https://mywebfolio.me/Kiss-HMVC/
 * @copyright   Copyright (c) 2020, David Connelly, https://trongate.io/
 * @copyright   Copyright (c) 2014 - 2020, British Columbia Institute of Technology, https://codeigniter.com/
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, https://ellislab.com/
 * @license     MIT License, https://opensource.org/licenses/MIT
 * @version     1.0.0
 * @todo        ...        
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

/**
 * Get Base URL
 * 
 * Attempt to get base URL if nothing is set.
 *
 * @param   void
 * @return  string
 */
function get_base_url()
{
  $url = explode('/',$_SERVER['REQUEST_URI']);
  $segmentOne = isset($url[0]) ? $url[0] : '';
  $segmentTwo = isset($url[1]) ? $url[1] : '';
  $url = 'http://localhost/' . ($segmentOne ? $segmentOne . '/' : '') . ($segmentTwo ? $segmentTwo : '') . '/';
  return $url;
}

function get_segment($num = 0)
{
  $uri =& load_class('Request','core');
  return $uri->segment($num); // needs fix: rendering text to screen
}

function get_segments()
{
  $uri =& load_class('Request','core');
  return $uri->_segments();
}

function get_current_url()
{
  $current_url =& load_class('Loader','core');
  $current_url->helper('url');
  return current_url();	
}

/*
 * ======================================================
 *  XSS Clean Function
 * ======================================================
 */
function xss_clean($str, $is_image = FALSE)
{ 
  $security =& load_class('Security','core');
  return $security->xss_clean($str, $is_image);
}

/*
 * ======================================================
 *  Load Class Function
 * ======================================================
 */
if ( ! function_exists('load_class') )
{
  /**
   * Loads and instantiates classes. This function acts like singleton or registry.
   *
   * @param   string
   * @return  array
   */
  function &load_class( $class, $directory = 'libraries', $params = NULL, $no_prfx = FALSE )
  {
    static $_classes = array();

    // Is class instantiated? If so, don't create a new one, return existing instead
    if (isset($_classes[$class]))
    {
      return $_classes[$class];
    }
	
    $class_name = FALSE;

    foreach (array(APPPATH, BASEPATH, MODULEPATH) as $path)
    {
      if (file_exists($path.$directory.DIR.$class.PHPXTNSN))
      {
        // If no prefix is set load class anyways for non-core classes
        if ( (strpos($class,'KISS_') === FALSE) AND ($no_prfx === TRUE) ) 
        {
          $class_name = $class;
        } 
        else 
        {
          $class_name = 'KISS_'.$class;
        }

        if (class_exists($class_name, FALSE) === FALSE)
        {
          require_once($path.$directory.DIR.$class.PHPXTNSN);
        }
 
        break;
      }
    }
	
    // If no class is found return error
    if ($class_name === FALSE)
    {
      http_response_code(503);
      echo 'Unable to locate the specified class: '.$class.PHPXTNSN;
    }

    // Keep track so base controller can loop through all the classes that were loaded
    is_loaded($class);
    $_classes[$class] = isset($params) ? new $class_name($params) : new $class_name();
    return $_classes[$class];
  }
}

/*
 * ======================================================
 *  Is Loaded Function
 * ======================================================
 */
if ( ! function_exists('is_loaded') )
{
  /**
   * Keeps track of loaded libraries. Used by load_class function.
   *
   * @param   string
   * @return  array
   */
  function &is_loaded($class = '')
  {
    static $is_loaded = array();

    if ($class !== '')
    {
      $is_loaded[strtolower($class)] = $class;
    }

    return $is_loaded;
  }
}

function show_404($page = NULL)
{
  $errors =& load_class('Error','core');
  return $errors->show_404($page);
}
  
function show_error($heading,$message,$template = 'Custom_Errors',$error_code = 500)
{
  $errors =& load_class('Error','core');
  return $errors->show_error($heading,$message,$template,$error_code);
}

  /**
   * Database configuration
   * 
   * Return DB by Reference, this function must be appended to a variable.
   * 
   * @param  void
   * @return static array $database
   */
  function &db_config()
  {
    static $database;
    if ( file_exists(APPPATH.'config/database.php') ) 
    {
      require_once APPPATH.'config/database.php';

      if ( isset($database) ) 
      {
        foreach( $database as $key => $val ) 
        {
          $database[$key] = $val;
        }
        return $database;
      }
    }
  }

  /**
   * Application configuration
   *
   * @param  void
   * @return static array $config
   */
  function &config()
  {
    static $config;
    if ( file_exists(APPPATH.'config/config.php') ) 
    {
      require_once APPPATH.'config/config.php';

      if ( isset($config) ) 
      {
        foreach( $config as $key => $val ) 
        {
          $config[$key] = $val;
        }
        return $config;
      }
    }
  }

  /**
   * Autoload
   *
   * @param  void
   * @return static array $autoload
   */
  function &autoload_config()
  {
    static $autoload;
    if ( file_exists(APPPATH.'config/autoload.php') ) 
    {
      require_once APPPATH.'config/autoload.php';

      if ( isset($autoload) ) 
      {
        foreach( $autoload as $key => $val ) 
        {
          $autoload[$key] = $val;
        }
        return $autoload;
      }
    }
  }

  function kiss_shutdown()
  {
    $last_error = error_get_last();
    if (isset($last_error) &&
      ($last_error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING)))
    {
      kiss_errors($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
    }
  }

  function kiss_exceptions($e)
  {
    $exception =& load_class('Error','core');
    $exception->show_exception($e);
  }

  function kiss_errors($errno, $errstr, $errfile, $errline)
  {
    $error =& load_class('Error','core');
    $error->show_php_error($errno, $errstr, $errfile, $errline);
  }

  // Init Config
  $CFG =& config();
