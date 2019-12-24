<?php
/**
 * Router Class
 *  
 * Routes controllers, modules, and methods depending on the URI request.
 *  
 * @package     KissHMVC
 * @subpackage  Core
 * @category    Router
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

class KISS_Router
{
  private $KISS;
  private $controller;
  private $module;
  private $action;
  private $params;
  private $uri;

  public function __construct($routes = NULL)
  {
  	$this->uri                = $routes;
    $this->controller         = $this->uri->_get_controller();
    $this->module             = $this->uri->_get_module();
    $this->action             = $this->uri->_get_action();
    $this->params             = $this->uri->_get_params();
    $this->_secure_backend();
  }


  /**
   * ===========================================================================
   *   IDEAS/TODOS
   * ===========================================================================
   * - Have modules like models, where you need to put _module suffix/prefix to prevent clashes between controllers and modules ?
   * - 
   * - 
   * - 
   * - 
   * - 
   * ===========================================================================
   */

  public function _secure_backend()
  {
    $uri = $this->uri->_segments();
    $protected_segments = array('application','system');
    foreach( $uri as $segment ) 
    {
      foreach( $protected_segments as $ps ) 
      {
        $protected_segments[] = strtolower($ps);
        if ( in_array( $segment, $protected_segments ) ) {
          show_404();
        }

        if ( ! in_array(array($this->controller),$protected_segments) AND $protected_segments[0] == $this->controller ) {
          if ( $this->_is_private($segment) ) {
            show_404();
          }
        }
      }
    }
  }


  /**
   * Is Private ?
   * 
   * Check if method contains an underscore, if so, that means it's private!
   * 
   * @param   string $var
   * @return  bool
   */
  protected function _is_private( $var )
  {
    // Checks first character for underscore, if there is, returns true
    $uri_to_match = substr($var[0],0,1);
    if ($uri_to_match === '_') {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function dispatch()
  {
    // Check if module exists
    $module =& load_class('Module','core');
    // Pass method to module class
    $_is_private = function($action) {
      return $this->_is_private($action);
    };

    if ( $module->get_module($this->module, $this->action, $this->params,$_is_private) == FALSE ) {

      // Check if controller exists
      if ( file_exists(CTRLPATH . $this->controller . PHPXTNSN) ) {
        require_once CTRLPATH . $this->controller . PHPXTNSN;
        $this->controller = new $this->controller();

        // Check if method or parameter exists
        if ( method_exists($this->controller,$this->action) ) {
          if ( $this->_is_private($this->action) ) {
            show_404();
          }
          if ( ! empty($this->params) ) {
            call_user_func_array(array($this->controller,$this->action),$this->params);
          } else {
            call_user_func(array($this->controller,$this->action));
          }
        } else {
          show_404();
        }
      }
    }
  }

}