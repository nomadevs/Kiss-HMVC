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

$route['blog']               = 'Blog';
$route['blog/post/(:any)']   = 'Blog/post/$1';
$route['dashboard']          = 'Dashboard/index';
$route['404_override']       = '';
$route['default_controller'] = 'Welcome/index';
$route['(:any)']             = 'Pages/view/$1';