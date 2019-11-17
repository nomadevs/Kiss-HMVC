<?php
/**
 * Base Controller
 *  
 * Base controller that all controllers extend. This controller is also a singleton and acts as a registry.
 *  
 * @package     KissHMVC
 * @subpackage  Core
 * @category    Base Controller
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
    log_message('info', 'Base Controller Initialized');
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
