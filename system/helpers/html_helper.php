<?php
/**
 * HTML Helper
 *  
 * Helper functions for rendering HTML
 *  
 * @package     Kiss-HMVC
 * @subpackage  Helpers
 * @category    HTML
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
