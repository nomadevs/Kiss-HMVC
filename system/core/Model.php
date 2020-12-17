<?php
/**
 * Model Class
 *  
 * All child models extend from this class. This class also handles
 * data from the database.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Core
 * @category    Base Model
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

class KISS_Model
{
  public function __construct(){}

  public function __get($key)
  {
    return get_instance()->$key;
  }
}
