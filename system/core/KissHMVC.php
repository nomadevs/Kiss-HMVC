<?php
/** 
 * KISS Bootstrap
 *  
 * Initializes framework, auto-loads classes, and includes any necessary files for the system to run.
 * 
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Bootstrap
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

const KISS_VERSION = '1.0.0';

// Application Constants
if ( file_exists(APPPATH.'config/constants'.PHPXTNSN) )
{
  require_once APPPATH.'config/constants'.PHPXTNSN;
}

// Global functions
require_once BASEPATH.'core/Functions'.PHPXTNSN;
// Framework constants
require_once BASEPATH.'core/Constants'.PHPXTNSN;

// Error handlers
set_error_handler('kiss_errors');
set_exception_handler('kiss_exceptions');
register_shutdown_function('kiss_shutdown');

// Instantiate core classes
$Request  =& load_class('Request', 'core');
$Router   =& load_class('Router', 'core', $Request);
$Security =& load_class('Security', 'core');


// Load base controller and base model
// We're able to extend the KISS_ prefix by requiring these two files.
require_once BASEPATH.'core/Controller'.PHPXTNSN;
require_once BASEPATH.'core/Model'.PHPXTNSN;

/**
 * Get instance of base controller
 *
 * @param   void
 * @return  object KISS_Controller
 */
function &get_instance()
{
  return KISS_Controller::get_instance();
}








