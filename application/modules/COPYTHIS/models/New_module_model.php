<?php
/** 
 * New module model.
 *
 * Give a description.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Modules
 * @category    Module Model
 * @author      Your Name or Company
 * @link        Your Website Address
 * @copyright   (c) Your Copyright Notice
 * @license     MIT License (https://opensource.org/licenses/MIT)
 * @version     1.0.0
 * @todo        Bug notes
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class New_module_model extends KISS_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table = '';
  }	
}
