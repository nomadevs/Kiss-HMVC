<?php
/** 
 * New module controller.
 *
 * Give a description.
 *  
 * @package     KissHMVC
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

class Dashboard extends KISS_Controller 
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('database', array(
          'db_host' => 'localhost',
          'db_user' => 'root',
          'db_pass' => '',
          'db_name' => 'kissmvcdb'
    ));
    $this->load->model('Dashboard/Dashboard_model');
    $this->model = $this->Dashboard_model;
  }	

  public function index()
  {
    $data['page_title'] = 'Dashboard';
    $data['body_class'] = 'dashboard-page';
    $data['view_file']  = 'dashboard';
    $data['view_module'] = 'Dashboard';
    $this->load->module('Templates/dashboard',$data);
  }
}
