<?php
/** 
 * New module controller.
 *
 * Give a description.
 *  
 * @package     Kiss-HMVC
 * @subpackage  Modules
 * @category    Module Controller
 * @author      Your Name or Company
 * @link        Your Website Address
 * @copyright   (c) Your Copyright Notice
 * @license     MIT License (https://opensource.org/licenses/MIT)
 * @version     1.0.0
 * @todo        Bug notes
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class New_module_controller extends KISS_Controller 
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('New_module/New_module_model');
    $this->model = $this->New_module_model;
  }	

  public function index()
  {
    $this->load->view('New_module/new_module_view');
  }
}
