<?php
defined('BASEPATH') OR exit('Direct script access not allowed');
/**
 * ===========================================
 *  URI ROUTING
 * ===========================================
 *
 *  Set your custom routes.
 * 
 * ===========================================
 */
 
$route['404_override']       = '';
$route['default_controller'] = 'Welcome/index';
$route['(:any)']             = 'Pages/view/$1';
