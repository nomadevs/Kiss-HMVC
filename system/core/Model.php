<?php
/**
 * Base Model
 *  
 * Base model that all models extend. This base model also has access to global variables.
 *  
 * @package     KissHMVC
 * @subpackage  Core
 * @category    Base Model
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

class KISS_Model
{
  public function __construct(){}

  public function __get($key)
  {
    return get_instance()->$key;
  }
}