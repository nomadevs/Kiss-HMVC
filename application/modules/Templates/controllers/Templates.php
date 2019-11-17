<?php
/** 
 * Templates module controller.
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

class Templates extends KISS_Controller 
{
  public function __construct()
  {
    parent::__construct();
  }	

  public function index(){}

  public function home($data)
  {
    $this->load->view('Templates/welcome',$data);
  }

  public function dashboard($data)
  {
    $this->load->view('Templates/header',$data);
    $this->load->view($data['view_module'].'/'.$data['view_file'],$data);
    $this->load->view('Templates/footer',$data);
  }

}
