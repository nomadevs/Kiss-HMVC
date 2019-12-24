<?php
defined('BASEPATH') OR exit('Direct script access not allowed');
/**
 * =======================================================
 *  Base URL                          
 * =======================================================
 *
 *  Don't forget a forward slash !
 *  
 * =======================================================
 */
$config['base_url']                = 'http://localhost/KISSHMVC/'; //http://localhost/KISSHMVC/

$config['permitted_uri_chars']     = 'a-z 0-9~%.:_\-'; // Don't edit these unless you know what you're doing!
/**
 * =======================================================
 *  Error Handling                       
 * =======================================================
 *
 *  Set error levels, turn errors on or off and set a
 *  directory for your error view files. When you're ready
 *  to go live set 'display_errors' to TRUE for production!
 *
 * =======================================================
 */
$config['log_threshold']           = 4; // 1-4 - Higher the digit the more errors are displayed
$config['ENV']                     = 'development';
$config['error_view_path']         = APPPATH . 'views'.DIR.'errors'.DIR;
$config['rewrite_short_tags']      = FALSE; // Support for older PHP versions
/**
 * =======================================================
 *  Session & Cookies                       
 * =======================================================
 *
 *  Settings for sessions and cookies.
 *
 * =======================================================
 */
$config['encryption_key']          = 'E0i3SfNtntaypu2owlxqdmXBtZ6i0NDm';
$config['sess_driver']             = ''; // Options: database or file
$config['sess_cookie_name']        = 'kiss_session';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = ''; // APPPATH.'sessions' or kiss_sessions
$config['sess_match_ip']           = FALSE;
$config['sess_time_to_update']     = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['sess_expire_on_close']    = FALSE;


$config['cookie_prefix']           = '';
$config['cookie_domain']           = '';
$config['cookie_path']             = '/';
$config['cookie_secure']           = FALSE;
$config['cookie_expiration']       = 86400; // 86400 - Seconds in 1 day
$config['cookie_httponly']         = TRUE;
