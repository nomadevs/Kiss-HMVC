<?php

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
        // If no prefix is set load class anyways
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

    // Keep track of what was loaded so base controller can loop through all the loaded classes
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



function _is_private( $var )
{
  // Checks first character for underscore, if there is, returns true
  $uri_to_match = substr($var[0],0,1);
  if ($uri_to_match === '_') {
    return TRUE;
  } else {
    return FALSE;
  }
}









if ( ! function_exists('log_message') )
{
  /**
   * Log Error Messages
   * 
   * Logs errors and informational messages to file for debugging.
   * 
   * 0 = Disables logging       (Disabled)
   * 1 = Error Messages         (Error)
   * 2 = Debug Messages         (Debug)
   * 3 = Informational Messages (Info)
   * 4 = All Messages           (All)
   * 
   * @param  string $error_lvl
   * @param  string $error_msg
   * @return void
   */
  function log_message($error_lvl, $error_msg) 
  {
    $config =& config();
    $error_lvl = strtoupper($error_lvl);
    $log_date = date('Y-m-d-H-i');
 
    if ( empty($config['log_path']) ) {
      //$log_path = $config['log_path'] = APPPATH.'logs\\';
    }

    $log_path = $config['log_path'] . 'log-' . $log_date . PHPXTNSN;
    $output = "<?php defined('BASEPATH') OR exit('Direct script access not allowed'); ?>\n\n";
    $output .= "$error_lvl -- $log_date --> $error_msg\n\n";
  
    //$file = fopen($log_path, "ab") or die("Unable to write log, you may not have file permissions, try setting CHMOD to 777.");
    //fwrite($file, $output);
    //fclose($file);  
  }
}


  function show_404($page = NULL)
  {
    $errors =& load_class('Errors','core');
    return $errors->show_404($page);
  }
  
  function show_error($heading,$message,$error_code)
  {
    $errors =& load_class('Errors','core');
    return $errors->show_error($heading,$message,$template = 'custom_errors',$error_code);
  }

  /**
   * Database configuration
   * 
   * Return DB by Reference, this function must be appended to a variable.
   * 
   * @param  void
   * @return static array $db_config
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
    $exception =& load_class('Errors','core');
    $exception->show_exception($e);
    $exception->log_errors($e->getCode(),$e->getMessage(),$e->getFile(),$e->getLine());
  }

  function kiss_errors($errno, $errstr, $errfile, $errline)
  {
    $error =& load_class('Errors','core');
    $error->show_php_error($errno, $errstr, $errfile, $errline);
    $error->log_errors($errno, $errstr, $errfile, $errline);
  }

  // Init Config
  $CFG =& config();