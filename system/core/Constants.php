<?php

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
define('BASEURL',$CFG['base_url'] ? $CFG['base_url'] : get_base_url());
define('FS','/');