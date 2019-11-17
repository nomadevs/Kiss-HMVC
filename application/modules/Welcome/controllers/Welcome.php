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
 * @license     MIT License (https://opensource.org/licenses/MIT)
 * @version     1.0.0
 * @todo        Bug notes
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class Welcome extends KISS_Controller 
{
  /**
   * Default module
   *
   * To view this module, you can navigate to the following URL(s):
   * 		http://yourdomain.com/index.php/welcome
   *	- or -
   * 		http://yourdomain.com/index.php/welcome/index
   *	- or -
   *        http://yourdomain.com/welcome (mod_rewrite enabled)
   *
   * By default this module is set as the default controller in
   * config/routes.php, which can be viewed here: http://yourdomain/ *    - or - http://localhost/KissHMVC/ (for offline)
   *
   * And any methods you create will route to:
   *    /index.php/<module>/<method>
   * 
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->library('database', array(
          'db_host' => 'localhost',
          'db_user' => 'root',
          'db_pass' => '',
          'db_name' => 'kissmvcdb'
    ));
    $this->load->model('Welcome/Welcome_model');
    $this->model = $this->Welcome_model;
  }

  public function index()
  {
    $data['page_title'] = 'Welcome to KissHMVC!';
    $data['body_class'] = 'welcome-page';
    $data['query'] =  $this->model->db->query("SELECT * FROM users");
    $this->load->module('Templates/home',$data);
  }

  
}
