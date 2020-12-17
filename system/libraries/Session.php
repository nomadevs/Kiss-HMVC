<?php
/**
 * Session Class
 *  
 * Handles sessions and flashdata.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Libraries
 * @category    Session
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

class KISS_Session
{
  private $config;
  public function __construct()
  {
    $this->config =& config();

    $this->config['sess_match_ip'] = ($this->config['sess_match_ip']) ? $this->config['sess_match_ip'] = (bool) $this->config['sess_match_ip'] : FALSE;
    $this->config['sess_save_path'] = ($this->config['sess_save_path']) ? $this->config['sess_save_path'] : NULL;

    if ( ! empty($this->config['cookie_prefix']) ) {
      $this->config['cookie_name'] = $this->config['sess_cookie_name'] ? $this->config['cookie_prefix'].$this->config['sess_cookie_name'] : NULL;
    } else {
      $this->config['cookie_name'] = $this->config['sess_cookie_name'] ? $this->config['sess_cookie_name'] : NULL;
    }

    if ( ! empty($this->config['sess_driver']) AND $this->config['sess_driver'] == 'database' AND $this->config['sess_save_path'] == 'kiss_sessions' ) {
      require_once 'Session/KissSessionDBHandler'.PHPXTNSN;
      $session_db_handler = new KissSessionDBHandler($this->config);
      session_set_save_handler($session_db_handler, TRUE);

    } elseif ( ! empty($this->config['sess_driver']) AND $this->config['sess_driver'] == 'file' ) {
      require_once 'Session/KissSessionFileHandler'.PHPXTNSN;
      $session_file_handler = new KissSessionFileHandler();
      session_set_save_handler($session_file_handler, TRUE);
    }

    if (empty($this->config['cookie_name']))
    {
      $this->config['cookie_name'] = ini_get('session.name');
    }
    else
    {
      ini_set('session.name', $this->config['cookie_name']);
    }

    if (empty($this->config['sess_expiration']))
    {
      $this->config['sess_expiration'] = (int) ini_get('session.gc_maxlifetime');
    }
    else
    {
      $this->config['sess_expiration'] = (int) $this->config['sess_expiration'];
      ini_set('session.gc_maxlifetime', $this->config['sess_expiration']);
    }

    $expired_session = $this->config['sess_expiration'];

    if (isset($this->config['cookie_expiration']))
    {
      $this->config['cookie_expiration'] = (int) $this->config['cookie_expiration'];
    }
    else
    {
      $this->config['cookie_expiration'] = ( ! isset($expired_session) AND $this->config['sess_expire_on_close']) ? 0 : (int) $expired_session;
    }

    $this->config['cookie_path'] = $this->config['cookie_path'] ? $this->config['cookie_path'] : '/';
    $this->config['cookie_domain'] = $this->config['cookie_domain'] ? $this->config['cookie_domain'] : NULL;
    $this->config['cookie_secure'] = $this->config['cookie_secure'] ? (bool) $this->config['cookie_secure'] : FALSE;
    session_set_cookie_params(
      $this->config['cookie_expiration'],
      $this->config['cookie_path'],
      $this->config['cookie_domain'],
      $this->config['cookie_secure'],
      TRUE
    ); // Last param set to TRUE to prevent XSS attacks!

    $sid_length = $this->_get_sid_length();

    // Security
    ini_set('session.use_trans_sid', 0);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.use_cookies', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.sid_length', $sid_length);

    session_start();

    if ( isset($_COOKIE[$this->config['cookie_name']]) ) {
      preg_match('/('.session_id().')/', $_COOKIE[$this->config['cookie_name']], $matches);
      if ( empty($matches) ) {
        unset($_COOKIE[$this->config['cookie_name']]);
      }
    }

    // Ignore ajax requests
    $regenerate_time = (int) $this->config['sess_time_to_update'];
    if ( (empty($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') AND ($regenerate_time > 0) ) {
      if ( ! isset($_SESSION['last_session_regenerate'])) {
        $_SESSION['last_session_regenerate'] = time();
      }
      elseif ( $_SESSION['last_session_regenerate'] < (time() - $regenerate_time) )
      {
        $this->sess_regenerate((bool) $this->config['sess_regenerate_destroy']);
      }
    } elseif (isset($_COOKIE[$this->config['cookie_name']]) AND $_COOKIE[$this->config['cookie_name']] === session_id()) {
      setcookie(
        $this->config['cookie_name'],
        session_id(),
        (empty($this->config['cookie_expiration']) ? 0 : time() + $this->config['cookie_expiration']),
        $this->config['cookie_path'],
        $this->config['cookie_domain'],
        $this->config['cookie_secure'],
        TRUE // Last param set to TRUE to prevent XSS attacks!
      );
    }
  }

  protected function _destroy_cookie()
  {
    return setcookie(
      $this->config['cookie_name'],
      NULL,
      1,
      $this->config['cookie_path'],
      $this->config['cookie_domain'],
      $this->config['cookie_secure'],
      TRUE
    );
  }

  private function _get_sid_length()
  {
    $bits_per_character = (int) ini_get('session.sid_bits_per_character');
    $sid_length         = (int) ini_get('session.sid_length');
    if (($bits = $sid_length * $bits_per_character) < 160)
    {
      // Add more characters to reach 160 bits
      $sid_length += (int) ceil((160 % $bits) / $bits_per_character);
    }
    return $sid_length;
  }

  public function set_flashdata($data, $value = NULL)
  {
    if (is_array($data))
    {
      foreach ($data as $key => $value)
      {
        $_SESSION[$key] = $value;
      }
      return;
    }
    $_SESSION[$data] = $value;
  }



  public function flashdata($key = NULL)
  {
    if ( isset($_SESSION[$key]) ) {
      $flash_data = $_SESSION[$key];
      unset($_SESSION[$key]);
      return $flash_data;
    }
  }

  public function sess_destroy()
  {
    session_destroy();
  }


  public function sess_regenerate($destroy = FALSE)
  {
    $_SESSION['last_session_regenerate'] = time();
    session_regenerate_id($destroy);
  }

}
