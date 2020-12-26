<?php
/**
 * Router Class
 *  
 * Routes controllers, modules, and methods given the URI request.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Router
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

class KISS_Router
{
  private $KISS;
  private $controller;
  private $module;
  private $action;
  private $params;
  private $request;

  public function __construct($request = NULL)
  {
    $this->request    = $request;
    $this->controller = $this->request->_get_controller();
    $this->module     = $this->request->_get_module();
    $this->action     = $this->request->_get_action();
    $this->params     = $this->request->_get_params();
    $this->_secure_backend();
  }


  public function _secure_backend()
  {
    $protected_segments = array('application','system');
    foreach( get_segments() as $segment ) 
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

    if ( $module->get_module($this->module, $this->action, $this->params,$_is_private) === FALSE ) {

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
