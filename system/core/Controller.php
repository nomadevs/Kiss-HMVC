<?php
/**
 * Controller Class
 *  
 * All child controllers extend from this class. This class functions
 * as a singleton that loads everything as a super-object.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Base Controller
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

class KISS_Controller 
{
  private static $instance;
  public         $load;

  public function __construct()
  {
    self::$instance =& $this;

    foreach (is_loaded() as $var => $class)
    {
      $this->$var =& load_class($class);
    }

    $this->load =& load_class('Loader', 'core');
    $this->input =& load_class('Input', 'core');
  }

  /**
   * Get KISSHMVC Singleton
   *
   * @static
   * @return  object
   */
  public static function &get_instance()
  {
    return self::$instance;
  }


}
