<?php
/**
 * URL Helper
 *  
 * URL helper functions.
 *  
 * @package     KissHMVC
 * @subpackage  Helpers
 * @category    URL
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

/**
 * Redirect
 *
 * Redirects to the given URL.
 *
 * @param   string $url
 * @return  void
 */
function redirect( $url = NULL )
{
  if ( ! empty($_POST) ) {
    if ( (strpos($url, 'http') !== FALSE) OR (strpos($url, 'www') !== FALSE) OR (strpos($url, 'https') !== FALSE) ) {
      header('Location: ' . $url);
    } else {
      header('Location: ' . BASEURL . $url);
    }
  }
}

/**
 * Base URL
 *
 * If a forward slash is present or nothing is provided, it returns the base_url set in (application/config/config.php).
 * 
 * @param   string $url
 * @return  string
 */
function base_url( $url = NULL )
{
  if ( $url == NULL OR $url == '/' ) {
    return BASEURL;
  }
  return BASEURL . $url;
}

/**
 * Site URL
 *
 * Similar to base_url() except it includes index page if set in app/config/config.php and includes any segments present.
 * 
 * @param   string $url
 * @return  string
 * @todo    Include segments from Request class
 */
function site_url( $url = NULL )
{
  $segmentOne = get_instance()->request->_segment(1);
  if ( $url == NULL OR $url == '/' ) {
    return BASEURL . ($segmentOne ? $segmentOne : '');
  }
  return BASEURL . ($segmentOne ? $segmentOne . '/' : '') . $url;
}

function url_title($str, $separator = '-', $lowercase = FALSE)
{
  if ($separator === 'dash')
  {
    $separator = '-';
  }
  elseif ($separator === 'underscore')
  {
    $separator = '_';
  }

  $q_separator = preg_quote($separator, '#');

  $trans = array(
    '&.+?;'     => '',
    '[^\w\d _-]'    => '',
    '\s+'     => $separator,
    '('.$q_separator.')+' => $separator
  );

  $str = strip_tags($str);
  foreach ($trans as $key => $val)
  {
    $str = preg_replace('#'.$key.'#i', $val, $str);
  }

  if ($lowercase === TRUE)
  {
    $str = strtolower($str);
  }

  return trim(trim($str, $separator));
}


