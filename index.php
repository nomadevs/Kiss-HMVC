<?php
/**
 * @package    KissHMVC Framework
 * @author     CitrusDevs <philosaphylas@gmail.com>
 * @copyright  Copyright (c) 2019 CitrusDevs (https://www.citrusdevs.x10.bz/)
 * @copyright  Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/, https://codeigniter.com/)
 * @copyright  Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @license    MIT License (https://opensource.org/licenses/MIT)
 * @link       https://demo.citrusdevs.x10.bz/kiss-hmvc
 * @credits    Inspired by CodeIgniter, Jesse Boyer <contact@jream.com>, John White <https://github.com/Jontyy>, StackOverflow, YouTube, and other online resources.
 * @version    1.1.0
 * @todo       Create 4 error levels 1-4
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