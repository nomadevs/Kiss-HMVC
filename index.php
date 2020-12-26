<?php
/**
 * @package     Kiss-HMVC
 * @category    Fontend
 * @author      nomadevs
 * @link        https://mywebfolio.me/
 * @copyright   Copyright (c) 2020, nomadevs, https://mywebfolio.me/Kiss-HMVC/
 * @copyright   Copyright (c) 2020, David Connelly, https://trongate.io/
 * @copyright   Copyright (c) 2014 - 2020, British Columbia Institute of Technology, https://codeigniter.com/
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, https://ellislab.com/
 * @license     MIT License, https://opensource.org/licenses/MIT
 * @version     1.0.0
 * @credits     CodeIgniter (https://codeigniter.com), David Connelly (https://trongate.ip), Jesse Boyer (https://jream.com), and many other resources.
 * @todo       ...
 */

// Define framework constants
define('DIR',DIRECTORY_SEPARATOR);
define('APPPATH', realpath('application').DIR);
define('BASEPATH', realpath('system').DIR,TRUE);
define('COREPATH', BASEPATH.'core'.DIR);
define('PHPXTNSN','.php');

// Require bootstrap file
require_once COREPATH.'KissHMVC'.PHPXTNSN;

// Display errors
switch (ENVIRONMENT)
{
  case 'development':
    error_reporting(-1);
    ini_set('display_errors', 1);
    break;

  case 'testing':
  case 'production':
    ini_set('display_errors', 0);
    error_reporting(0);
    break;

  default :
    error_reporting(-1);
    ini_set('display_errors', 1);
}

// Engage!
$Router->dispatch();
