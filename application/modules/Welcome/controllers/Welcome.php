<?php
/** 
 * Welcome module controller.
 *
 * Give a description.
 *  
 * @package     KissHMVC
 * @subpackage  Modules
 * @category    Module Controller
 * @author      Your Name or Company
 * @link        Your Website Address
 * @copyright   (c) Your Copyright Notice
 * @license     MIT License, https://opensource.org/licenses/MIT
 * @version     1.0.0
 * @todo        Bug notes
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class Welcome extends KISS_Controller 
{
  /**
   * Default module
   *
   * To view this module, you can navigate to the following URLs:
   * 		http://yourdomain.com/index.php/welcome
   *	- or -
   * 		http://yourdomain.com/index.php/welcome/index <method>
   *	- or -
   *        http://yourdomain.com/welcome
   *
   * By default this module is set as the default controller in:
   * ~/application/config/routes.php
   *
   * ~/index.php/<module>/<method>/<param>
   * 
   */
  public function __construct()
  {
    parent::__construct();	
  }

  public function index()
  {
    $data['page_title'] = "Welcome to Kiss-HMVC!";
    $data['body_class'] = "welcome";
    $this->load->view('Welcome/welcome',$data);
  }

  
}
