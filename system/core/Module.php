<?php
/**
 * Module Class
 *  
 * Handles module related tasks
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Base Module
 * @author      nomadevs
 * @link        https://mywebfolio.me/
 * @copyright   Copyright (c) 2020, nomadevs, https://mywebfolio.me/Kiss-HMVC/
 * @copyright   Copyright (c) 2020, David Connelly, https://trongate.io/
 * @copyright   Copyright (c) 2014 - 2020, British Columbia Institute of Technology, https://codeigniter.com/
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, https://ellislab.com/
 * @license     MIT License, https://opensource.org/licenses/MIT
 * @version     1.0.0
 * @todo        Add module suffix similar to models to avoid conflicts.        
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class KISS_Module
{
  public function __construct(){}

  /**
   * Get Module
   * 
   * Gets requested module. Used by Router class dispatch method. Returns false if module is not present.
   * 
   * @param   string  $module
   * @param   string  $action
   * @param   string  $param
   * @param   mixed   $_is_private  (anonymous_function|boolean)
   * @return  boolean
   * @todo    
   */
  public function get_module($module, $action, $param, $_is_private)
  {
    if ( file_exists(MODULEPATH . $module . DIR . 'controllers' . DIR . $module .  PHPXTNSN) AND is_dir(MODULEPATH . $module) ) {
      require_once MODULEPATH . $module . DIR . 'controllers' . DIR . $module .  PHPXTNSN;
      $module = new $module();
      // Check if method or parameter exists
      if ( method_exists($module,$action) ) {
        if ( $_is_private($action) ) {
          show_404();
        }
        if ( ! empty($param) ) {
          call_user_func_array(array($module,$action),$param);
        } else {
          call_user_func(array($module,$action));
        }
      } else {
        show_404();
      }
    } else {
      return FALSE;
    }
  }

  /**
   * Module
   * 
   * Loads modules, returns false if none are present.
   * 
   * @param   string  $module
   * @param   array   $data    (optional)
   * @return  mixed   $_module (object|boolean)
   * @todo    Use regular expression to check _model prefix/suffix variations; check to see if I even need to set db property (i.e. model->db = $KISS->db)
   */
  public function module( $module, $data = array())
  {
    $KISS =& get_instance();
    if ( ( strpos($module,'/') !== FALSE ) ) {

      $_module_segment = explode('/',$module);
      $_module_controller = $_module_segment[0];
      // Pass db connection to the current controller model
      $_module_model = $_module_controller.'_model';
      $_module_model = $this->model($_module_controller.'/'.$_module_model);
      $_module_model->db = '';
      $_module_model->db = $KISS->db;

      if ( file_exists(MODULEPATH . $_module_controller . DIR . 'controllers' . DIR . $_module_controller . PHPXTNSN) ) {
        require_once MODULEPATH . $_module_controller . DIR . 'controllers' . DIR . $_module_controller . PHPXTNSN;
        if ( count($_module_segment) > 1 ) {
           $_module = new $_module_controller();
           $KISS->$_module_controller = $_module;
           $_module->{$_module_segment[1]}($data); // check if private, if has underscore ?
           return $_module;
        } 
      } else {
      	return FALSE;
      }
    } else {   
      if ( file_exists(MODULEPATH . $module . DIR . 'controllers' . DIR . $module . PHPXTNSN) ) {
        require_once MODULEPATH . $module . DIR . 'controllers' . DIR . $module . PHPXTNSN;
        $_module_model = $module.'_model';
        $_module_model = $this->model($module.'/'.$_module_model);
        $_module_model->db = '';
        $_module_model->db = $KISS->db;
        //$_module_path = $module . DIR . 'controllers';
        //$_module =& load_class($module,$_module_path,'',TRUE);
        $_module = new $module();
        $_module->index($data);
        $KISS->$module = $_module;
        return $_module;
      } else {
      	return FALSE;
      }
    }
  }

  /**
   * Model
   * 
   * Loads module models, returns false if none are present.
   * 
   * @param   string  $model
   * @return  mixed   $_model (object|boolean)
   * @todo    
   */
  public function model( $model )
  {
    // Load module models
    if ( strpos($model,'_') !== FALSE AND strpos($model,'/') ) 
    {
      $_model_segment     = explode('/',$model);
      $_module_controller = $_model_segment[0];
      $_module_model      = $_model_segment[1];

      if ( file_exists(MODULEPATH . $_module_controller . DIR . 'models' . DIR . $_module_model . PHPXTNSN) ) 
      {
        require_once MODULEPATH . $_module_controller . DIR . 'models' . DIR . $_module_model . PHPXTNSN;
        $_model_path = $_module_controller.DIR.'models';
        $_model =& load_class($_module_model,$_model_path,'',TRUE);
        $KISS =& get_instance();
        $KISS->$_module_model = $_model;
        return $_model;
      } else {
        trigger_error(ucfirst($_module_model).' model is missing or does not exist!',E_USER_WARNING);
        return FALSE;
      }
    }
  }

  /**
   * View
   * 
   * Loads module views, returns false if none are present.
   * 
   * @param   string  $view
   * @param   array   $data  (optional)
   * @return  boolean
   * @todo    
   */
  public function view( $view, $data = array())
  {
  	extract($data);

    $KISS =& get_instance();
    foreach (get_object_vars($KISS) as $kissKey => $kissVal)
    {
      if ( ! isset($this->$kissKey))
      {
        $this->$kissKey =& $KISS->$kissKey;
      }
    }

    if ( strpos($view,'/') !== FALSE ) {
      $view = explode('/', $view);
      $module_dir = $view[0];
      $module_view = $view[1];

      if ( is_dir($module_dir = MODULEPATH.$module_dir.DIR) ) 
      {
        if ( is_dir($module_view_dir = $module_dir.'views') )
        { 
          if ( file_exists($module_view_file = $module_view_dir.DIR.$module_view.PHPXTNSN) ) 
          {
            require_once $module_view_file;
          } else {
            trigger_error("Unable to locate <b>{$module_view}</b> module view, file is either missing, does not exist, or you made a typo!", E_USER_WARNING);
          }
        } else {
          trigger_error("Module view folder is missing!", E_USER_WARNING);
        }
      } else {
        trigger_error("The view you're trying to load has no module folder!", E_USER_WARNING);
      }
    } else {
      return FALSE;
    }
  }

}
