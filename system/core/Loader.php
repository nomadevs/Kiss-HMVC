<?php
/**
 * Loader Class
 *  
 * Loads components for the framework (e.g. Controllers, Modules, etc.)
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Loader
 * @author      nomadevs
 * @link        https://nomadevs.github.io/Kiss-HMVC
 * @copyright   Copyright (c) 2020, nomadevs <https://nomadevs.github.io/Kiss-HMVC>
 * @copyright   Copyright (c) 2020, David Connelly <https://trongate.io>
 * @copyright   Copyright (c) 2014 - 2020, British Columbia Institute of Technology <https://codeigniter.com>
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. <https://ellislab.com>
 * @license     MIT License <https://opensource.org/licenses/MIT>
 * @version     1.0.0
 * @todo        ...          
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class KISS_Loader
{
  public function __construct()
  {
    $this->_autoloader();
  }

  /**
   * Library
   * 
   * Loads system libraries and custom libraries.
   * 
   * @param   array  $library
   * @param   array  $config (optional)
   * @return  object $_library
   * @todo    Also, check in application folder for custom libraries
   */
  public function library($library,$config = array())
  {
    $KISS =& get_instance();
    // Loading multiple libraries, checking for additional parameters, and whether database is being loaded.
    if ( is_array($library) ) {
      foreach( $library as $lib ) {
        if ( ! empty($config) AND is_array($config) ) {
          $_library =& load_class($lib,'libraries',$config);
        } else {
          $_library =& load_class($lib,'libraries');
        }
        
        if ( $lib == 'database') {
          // Initialize variable to prevent errors
          $KISS->db = '';
          $KISS->db = $_library;
        } else {
          $KISS->$lib = $_library;
        }
        return $_library;
      }
    }
    // Checking for additional parameters, and whether database is being loaded
    if ( ! empty($config) AND is_array($config) ) {
      $_library =& load_class($library,'libraries',$config);
    } else {
      $_library =& load_class($library,'libraries');
    }

    if ( $library == 'database') {
      // Initialize variable to prevent errors
      $KISS->db = '';
      $KISS->db = $_library;
    } else {
      $KISS->$library = $_library; // Acts as a registry
    } 
    return $_library;
  }

  public function is_loaded($class)
  {
    foreach( is_loaded() as $_class ) {
      if ( $class == $_class ) {
        return $class;
      }
    }
  }

  public function database()
  {
    $KISS =& get_instance();
    $database =& load_class('Database','database');
    // Initialize variable to prevent errors
    $KISS->db = '';
    $KISS->db = $database;
    return $database;
  }

  public function controller( $controller, $data = array() )
  {
    $KISS =& get_instance();
    if ( (strpos($controller,'/') !== FALSE) ) {
      $_controller_segment = explode('/', $controller);
      $_controller = $_controller_segment[0];
      // Pass db connection to the current controller model
      $_controller_model = $_controller.'_model';
      $_controller_model = $this->model($_controller_model);
      $_controller_model->db = '';
      $_controller_model->db = $KISS->db;
      if ( file_exists(CTRLPATH.$_controller.PHPXTNSN) ) {
        require_once CTRLPATH.$_controller.PHPXTNSN;     
        if ( count($_controller_segment) > 1 ) {
          $_controller = new $_controller();
          $KISS->$controller = $_controller;
          $_controller->{$_controller_segment[1]}($data);
        } 
      }
    } else {
      if ( file_exists(CTRLPATH.$controller.PHPXTNSN) ) {
        require_once CTRLPATH.$controller.PHPXTNSN;
        // Pass db connection to the current controller model
        $_controller_model = $controller.'_model';
        $_controller_model = $this->model($_controller_model);
        $_controller_model->db = '';
        $_controller_model->db = $KISS->db;
        $_controller = new $controller();
        $_controller->index($data);
        $KISS->$controller = $_controller;
        return $_controller;
      }
    }
  }

  public function module( $module, $data = array() )
  { 
    if ( get_instance()->module->module($module,$data) == FALSE ) {
      trigger_error(ucfirst($module).' Module does not exist!',E_USER_WARNING);
    }
  }

  public function view($view, $data = array())
  {
    extract($data);
    // Gets $this->load working in view file 
    $KISS =& get_instance();
    foreach (get_object_vars($KISS) as $kissKey => $kissVal)
    {
      if ( ! isset($this->$kissKey))
      {
        $this->$kissKey =& $KISS->$kissKey;
      }
    }

    if ( get_instance()->module->view($view,$data) == FALSE ) {
      $config =& config();
      $rewrite_short_tags = (bool) $config['rewrite_short_tags'];

      if ( file_exists(VIEWPATH . $view . PHPXTNSN) ) {
        // Rewrite short open tag for older versions of PHP; Since 5.4.0 short_open_tags always on
        // 5.6.40 ~ 50640
        if ( PHP_VERSION_ID < 50400 AND !ini_get('short_open_tag') AND $rewrite_short_tags !== FALSE ) {
          echo eval('?>'.preg_replace('/;*\s*\?>/', '; ?>', str_replace('<?=', '<?php echo ', file_get_contents(VIEWPATH . $view . PHPXTNSN))));
        } else {
          require_once VIEWPATH . $view . PHPXTNSN;
        }
      } else {
        if ( strpos($view,'/') == FALSE ) {
          trigger_error(ucfirst($view).' view is missing or does not exist!',E_USER_WARNING);
        }
      }
    }
  }


  public function model($model)
  {
    if ( get_instance()->module->model($model) == FALSE ) {
      if ( file_exists(MODELPATH . $model . PHPXTNSN) ) {
        $_model =& load_class($model,'models','',TRUE);
        $KISS =& get_instance();
        $KISS->$model = $_model;
        return $_model;
      } else {
        if ( strpos($model,'/') == FALSE ) {
          trigger_error(ucfirst($model).' model is missing or does not exist!',E_USER_WARNING);
        }
      }
    }
  }

  /**
   * Helper
   *
   * Loads system helpers and custom helpers.
   * 
   * @todo   
   * @param  string $helper
   * @return void
   */
  public function helper($helper)
  {
    // Load multiple helpers
    if ( is_array($helper) ) {
      foreach( array(APPPATH.'helpers',BASEPATH.'helpers') as $dir ) {
        foreach( $helper as $hlpr ) {
          if ( file_exists($dir.DIR.$hlpr.HLPRSFX.PHPXTNSN) ) {
            require_once $dir.DIR.$hlpr.HLPRSFX.PHPXTNSN;
          }
        }
      }
    } else {
      foreach( array(APPPATH.'helpers',BASEPATH.'helpers') as $dir ) {
        if ( file_exists($dir.DIR.$helper.HLPRSFX.PHPXTNSN) ) {
          require_once $dir.DIR.$helper.HLPRSFX.PHPXTNSN;
        }
      }
    }
  }

  public function package($package)
  {
    foreach( $package as $pckg ) {
      require_once($pckg);
    }
  }

  

  public function _autoloader()
  {
    $autoload =& autoload_config();

    if ( isset( $autoload['library'][0] ) ) {
      $this->library($autoload['library']);
    }
    if ( isset( $autoload['helper'][0] ) ) {
      $this->helper($autoload['helper']); 
    }
    if ( isset( $autoload['model'][0] ) ) {
      $this->model($autoload['model']);
    }
    if ( isset( $autoload['module'][0] ) ) {
      $this->module($autoload['module']);
    }
    if ( isset( $autoload['controller'][0] ) ) {
      $this->controller($autoload['controller']);
    }
    if ( isset( $autoload['package'][0] ) ) {
      $this->package($autoload['package']);
    }
  }

}
