<?php
/**
 * HTML Helper
 *  
 * HTML helper functions.
 *  
 * @package     KissHMVC
 * @subpackage  Helpers
 * @category    HTML
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
 * Anchor tag
 *
 * @param   string $url
 * @param   string $title
 * @param   array  $attributes
 * @return  string
 */
function anchor($url = '', $title = '', $attributes = '')
{
  get_instance()->load->helper(array('form','url'));
  $title = is_string($title) ? $title : NULL;
  $url = is_string($url) ? $url : NULL;
  $attrs = _attributes_to_string($attributes);
  $site_url = site_url($url);
  return '<a href="'.$site_url.'"'.$attrs.'>'.$title.'</a>';
}