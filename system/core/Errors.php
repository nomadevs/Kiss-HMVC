<?php
/** 
 * Errors Class
 *  
 * Displays framework errors, and logs error messages.
 * 
 * @package     KissHMVC
 * @subpackage  Core
 * @category    Errors
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

class KISS_Errors
{
  /**
   * Error Logger
   *
   * Logs PHP generated errors and exceptions to file.
   * 
   * @param  int     $error_lvl  Error Level
   * @param  string  $message    Error Message
   * @param  string  $filepath   Error File Path
   * @param  int     $line       Error Line Number
   * @return void
   */
  public function log_errors($error_lvl, $message, $filepath, $line)
  {
    log_message('error', 'Severity: '.$error_lvl.' --> '.$message.' '.$filepath.' '.$line);
  }

  /**
   * Show 404 Error
   *
   * @param	  string  $page
   * @return  void
   */
  public function show_404($page = '')
  {
    $heading = '404 Page Not Found';
    $message = 'The page you requested was not found.';

    log_message('error', $heading.': '.$page);
    $this->show_error($heading, $message, '404', 404);
  }

  /**
   * Show Error
   *
   * Displays custom errors
   *
   * @param   string  $heading         Error Heading
   * @param   string  $message         Error Message
   * @param   string  $template        Error Template
   * @param   int     $error_lvl_code  Error Level
   * @return  void
   */
  public function show_error($heading, $message, $template = 'custom_errors', $error_lvl_code = 500)
  {
    $config =& config();
    $template_path = $config['error_view_path'];
  
    if (empty($template_path))
    {
      $template_path = VIEWPATH.'errors'.DIR;
    }
    http_response_code($error_lvl_code);
    require_once($template_path.$template.'.php');
    die();
  }

  public function show_exception($exception)
  {
    $config =& config();
    $template_path = $config['error_view_path'];
    if (empty($template_path))
    {
      $template_path = VIEWPATH.'errors'.DIR;
    }

    $message = $exception->getMessage();
    if (empty($message))
    {
      $message = '(null)';
    }

    require_once($template_path.'Exceptions.php');
    die();
  }

  /**
   * PHP Errors handler
   *
   * @param  int     $severity  Error Level
   * @param  string  $message   Error Message
   * @param  string  $filepath  Error File Path
   * @param  int     $line      Line number
   * @return void
   */
  public function show_php_error($severity, $message, $filepath, $line)
  {
  	$config =& config();
    $template_path = $config['error_view_path'];
    if (empty($template_path))
    {
      $template_path = VIEWPATH.'errors'.DIR;
    }
    require_once($template_path.'Errors.php');
    die();
  }

}