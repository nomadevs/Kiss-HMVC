<?php
/**
 * Input Class
 *  
 * Handles postdata, cookies, etc.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Input
 * @author      nomadevs
 * @link        https://nomadevs.github.io/Kiss-HMVC
 * @copyright   Copyright (c) 2020, nomadevs <https://nomadevs.github.io/Kiss-HMVC>
 * @copyright   Copyright (c) 2020, David Connelly <https://trongate.io>
 * @copyright   Copyright (c) 2014 - 2020, British Columbia Institute of Technology <https://codeigniter.com>
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. <https://ellislab.com>
 * @license     MIT License <https://opensource.org/licenses/MIT>
 * @version     1.0.0
 * @todo        ...         
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class KISS_Input
{
  private $security;
  
  public function __construct()
  {
    global $Security;
    $this->security = $Security;
  }
  


  public function post($post = NULL, $xss_clean = FALSE)
  {
    if ( isset($_POST[$post]) ) {
      if ( $xss_clean === TRUE ) {
        return $this->security->xss_clean($_POST[$post]);		
      } else {
        return $_POST[$post];	
      }
    }
  }

  public function get($get = NULL, $xss_clean = FALSE)
  {
    if ( isset($_GET[$get]) ) {
      if ( $xss_clean === TRUE ) {
        return $this->security->xss_clean($_GET[$get]);
      } else {
        return $_GET[$get];
      }
    }
  }

  public function cookie($cookie = NULL, $xss_clean = FALSE)
  {
    if ( isset($_COOKIE[$cookie]) ) {
      if ( $xss_clean === TRUE ) {
        return $this->security->xss_clean($_COOKIE[$cookie]);		
      } else {
        return $_COOKIE[$cookie];	
      }
    }
  }

  public function set_cookie($name, $value = '', $expire = '', $domain = '', $path = '/', $prefix = '', $secure = NULL, $httponly = NULL)
  {
    if (is_array($name))
    {
      // Leave 'name' in last place or loop will break cause 'name' and '$$item' will end up containing the same name
      foreach (array('value', 'expire', 'domain', 'path', 'prefix', 'secure', 'httponly', 'name') as $item)
      {
        if (isset($name[$item]))
        {
          $$item = $name[$item];
        }
      }
    }

    $config =& config();

    if ($prefix === '' && $config['cookie_prefix'] !== '')
    {
      $prefix = $config['cookie_prefix'];
    }

    if ($domain == '' && $config['cookie_domain'] != '')
    {
      $domain = $config['cookie_domain'];
    }

    if ($path === '/' && $config['cookie_path'] !== '/')
    {
      $path = $config['cookie_path'];
    }

    $secure = ($secure === NULL && $config['cookie_secure'] !== NULL)
      ? (bool) $config['cookie_secure']
      : (bool) $secure;

    $httponly = ($httponly === NULL && $config['cookie_httponly'] !== NULL)
      ? (bool) $config['cookie_httponly']
      : (bool) $httponly;

    if ( ! is_numeric($expire))
    {
      $expire = time() - 86500;
    }
    else
    {
      $expire = ($expire > 0) ? time() + $expire : 0;
    }

    setcookie($prefix.$name, $value, $expire, $path, $domain, $secure, $httponly);
  }

  public function ip_address() 
  {
    if ( filter_var($this->server('REMOTE_ADDR'), FILTER_VALIDATE_IP) !== FALSE ) {
      return $this->server('REMOTE_ADDR',TRUE);
    } else {
      return '0.0.0.0';
    }
  }

  public function user_agent()
  {
    return $this->server('HTTP_USER_AGENT',TRUE);
  }

  public function server($server = NULL, $xss_clean = FALSE)
  {
    if ( isset($_SERVER[$server]) ) {
      if ( $xss_clean === TRUE ) {
        return $this->security->xss_clean($_SERVER[$server]);
      } else {
        return $_SERVER[$server];
      }
    }
  }

}
