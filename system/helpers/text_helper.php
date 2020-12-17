<?php
/**
 * Text Helper
 *  
 * Helper functions for Text
 *  
 * @package     Kiss-HMVC
 * @subpackage  Helpers
 * @category    Text
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

function word_limiter($str, $limit = 100, $end_char = '&#8230;')
{
  if (trim($str) === '')
  {
    return $str;
  }

  preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);

  if (strlen($str) === strlen($matches[0]))
  {
    $end_char = '';
  }

  return rtrim($matches[0]).$end_char;
}
