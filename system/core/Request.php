<?php
/**
 * Request Class
 *  
 * Preps URI in to usable segments for Router class to utilize.
 *  
 * @package     KissHMVC
 * @subpackage  Core
 * @category    Request
 * @author      CitrusDevs
 * @link        https://demo.citrusdevs.x10.bz/kiss-hmvc
 * @copyright   Copyright (c) 2019 CitrusDevs (https://www.citrusdevs.x10.bz/)
 * @copyright   Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/, https://codeigniter.com/)
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @license     MIT License (https://opensource.org/licenses/MIT)
 * @version     1.1.0
 * @todo        
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class KISS_Request
{
  private $segments           = array();
  private $rsegments          = array();
  private $params             = array();
  private $default_controller = NULL;
  private $error_controller   = 'errors';
  private $default_action     = 'index';
  private $controller;
  private $module;
  private $action;


  public function __construct()
  {
    $this->_set_requests();
    $this->_set_routes();
    $this->_set_params();
    $this->module = $this->_is_module($this->_rsegment(1)) ? $this->_rsegment(1) : $this->default_controller;
    $this->controller = $this->_rsegment(1) ? $this->_rsegment(1) : $this->default_controller;
    $this->action = $this->_rsegment(2) ? $this->_rsegment(2) : $this->default_action;
  }

  public function _segment($num = NULL)
  {
    return isset($this->segments[$num]) ? $this->segments[$num] : NULL;
  }

  public function _rsegment($num = NULL)
  {
    return isset($this->rsegments[$num]) ? $this->rsegments[$num] : NULL;
  }

  public function _rsegments()
  {
    return $this->rsegments;
  }

  public function _segments()
  {
    return $this->segments;
  }

  public function _get_params()
  {
    return $this->params;
  }

  public function _get_controller()
  {
    return $this->controller;
  }

  public function _is_module( $module )
  {
    if ( is_dir( MODULEPATH . $module ) ) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function _get_module()
  {
    return $this->module;
  }

  public function _get_action()
  {
    return $this->action;
  }

  /**
   * Set Routes
   * 
   * Set any custom routes that are set.
   * 
   * @param   void
   * @return  array
   */
  private function _set_routes()
  {
    if ( file_exists(APPPATH.'config/routes.php') ) {
      require_once APPPATH.'config/routes.php';
    }

    // Check if routes are set
    if ( isset( $route ) AND is_array($route) ) 
    {
      $uri = $this->_segments();
      $uri = implode('/', $uri);

      isset($route['default_controller']) ? $this->default_controller = $route['default_controller'] : $this->default_controller;
      isset($route['404_override']) ? $this->error_controller = $route['404_override'] : $this->error_controller;

      // Check for wildcards
      foreach( $route as $key => $val )
      {
        // Convert wildcards to regular expressions
        $key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);

        // Does uri match custom route ?
        if ( preg_match('#^'.$key.'$#', $uri, $matches) )
        {
          // Does the key/value pair contain the following characters, if so, then we're using wildcards!
          if ( strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE ) 
          { 
            // Replaces val placeholders/wildcards with the matching uri segment
            $val = preg_replace('#^'.$key.'$#', $val, $uri);
          }
          $this->_set_route(explode('/', $val));
          return; // stop script
        }
      }
    }
    // If no custom routes are set, set default routes
    $this->_set_route(array_values($this->_segments())); 
  }

  public function _set_route($route = NULL)
  {
    // All custom and default routes get piped through this method and starting index gets set to 1
    if (empty($route) AND strpos($this->default_controller, '/'))
    {
      $route = explode('/',$this->default_controller);
    }
    elseif (empty($route))
    {
      $route = array($this->default_controller);
    }



    if ( $this->error_controller == 'errors' ) {
      $error_message = '';
      $this->error_controller = 'errors/show_error/'.$error_message;
      $route = explode('/',$this->error_controller);
    } else {
      //$route = explode('/',$this->error_controller);
    }
  
    $count = 0;
    foreach( $route as $_route ) {
      $count++;
       $this->rsegments[$count] = $_route;
    }
 
  }



  public function _set_requests()
  {
    $uri = $_SERVER['REQUEST_URI'];

    foreach (explode('/',trim($uri, '/')) as $uri)
    {
      $uri = strtolower(trim($uri)); // Trim empty/white space characters

      // Filter segments for security
      $uri = filter_var($uri,FILTER_SANITIZE_URL);
      $config =& config();

      if ( ! empty($uri) )
      {
        if ( ! preg_match('/^['.$config['permitted_uri_chars'].']+$/i', $uri) ) {
          trigger_error("The characters you entered in the URL are not permitted!",E_USER_WARNING);
          $this->segments[] = NULL;
        } else {
          $this->segments[] = $uri;
        }
        unset($this->segments[0]); // Get rid of folder segment
      }
    }
  }

  /**
   * Set Params
   * 
   * Take an array of parameters and return as strings.
   *
   * @param   void
   * @return  void
   */
  public function _set_params()
  {
    $count = 2;
    foreach( $this->_rsegments() as $segment ) 
    {
      if ( count($this->_rsegments()) > 2 ) 
      {
        $count++;
        $this->params[] = $this->_rsegment($count) ? $this->_rsegment($count) : array();
      }
    }
  }



}

