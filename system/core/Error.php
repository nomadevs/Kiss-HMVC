<?php
/** 
 * Error Class
 *  
 * Displays framework errors, and logs error messages.
 * 
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Errors
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

class KISS_Error
{
  /**
   * Show 404 Error
   *
   * @param	  string  $page
   * @return  void
   */
  public function show_404($page = '')
  {
    $page = isset($page) ? $page : '404';
    $heading = '404 Page Not Found';
    $message = 'The page you requested was not found.';
    $this->show_error($heading, $message, $page, 404);
  }

  /**
   * Show Error
   *
   * Displays custom errors
   *
   * @param   string  $heading         Error Heading
   * @param   string  $message         Error Message
   * @param   string  $template        Error Template
   * @param   int     $error_code      Error Level
   * @return  void
   */
  public function show_error($heading, $message, $template = 'Custom_Errors', $error_code = 500)
  {
    $config =& config();
    $template_path = $config['error_view_path'];
  
    if (empty($template_path))
    {
      $template_path = VIEWPATH.'errors'.DIR;
    }
    http_response_code($error_code);
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
