<?php
/**
 * Constants
 *  
 * Framework constants necessary for the system to run.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Framework Constants
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
/*
| ===============================================================================
|  Framework Constants
| ===============================================================================
|  
|  Please Note:
|  
|  It's not recommended to define your constants here unless you know what
|  what you're doing. You can create your own constants here: 
|  ~/application/config/constants.php
|  
| ===============================================================================
|    
*/
define('ENVIRONMENT',$CFG['ENV']);
define('KSPRFX','KISS_');
define('VIEWPATH', APPPATH.'views'.DIR);
define('MODELPATH',APPPATH.'models'.DIR);
define('CTRLPATH',APPPATH.'controllers'.DIR);
define('MODULEPATH',APPPATH .'modules'.DIR);
define('DBPATH',BASEPATH.'database'.DIR);
define('LIBPATH',BASEPATH.'libraries'.DIR);
define('HLPRPATH',BASEPATH.'helpers'.DIR);
define('HLPRSFX','_helper');
define('BASEURL',$CFG['base_url'] ? $CFG['base_url'] : get_base_url()); // If base url is set it will be used, otherwise, the framework will try to figure it out.
define('FS','/');
