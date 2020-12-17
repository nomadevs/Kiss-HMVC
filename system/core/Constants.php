<?php 
defined('BASEPATH') OR exit('Direct script access not allowed');
/*
| ===============================================================================
|  Framework Constants
| ===============================================================================
|
|  Framework constants necessary for the system to run.
|  
|  Please Note:
|  
|  It's not recommended to define your constants here unless you know what
|  what you're doing. You can create your own constants by navigating here: 
|  /application/config/constants.php
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
