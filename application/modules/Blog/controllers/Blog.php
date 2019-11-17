<?php
/** 
 * Blog module controller.
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

class Blog extends KISS_Controller 
{
  public function __construct()
  {
    parent::__construct();
    $_POST['test'] = 'testttttt';
    echo $this->input->post('test',TRUE);
    // Set local timezone
    date_default_timezone_set('America/Vancouver');

    $this->load->library('database', array( //IDEA: if db config isn't passed, load database anyways cause this option is mainly for connecting to multiple databases
          'db_host' => 'localhost',
          'db_user' => 'root',
          'db_pass' => '',
          'db_name' => 'kissmvcdb'
    ));
    $this->load->helper('text');
    $this->load->model('Blog/Blog_model');
    $this->model = $this->Blog_model;
    $this->load->library('Custom_Dates');
     $this->session->set_flashdata(array('test8'=>'blaasaasdfsdfsdf!!!'));
     //echo url_title('Escaping the petri-dish');
     $this->db->query("SELECT * FROM posts");
    
  }

  public function index()
  { 
    $data['posts'] = $this->model->get_posts()->result_array();
    $data['site_title'] = 'Blog';
    $data['page_title'] = 'Blog';
    $data['body_class'] = 'blog-page';
    $this->load->view('Blog/header',$data);
    $this->load->view('Blog/posts',$data);
    $this->load->view('Blog/footer',$data);
  }

  public function post($slug = NULL)
  {
    $data['post'] = $this->model->get_post($slug);
    $data['site_title'] = $data['post']['post_title'];
    $data['page_title'] = $data['post']['post_title'];
    $data['body_class'] = 'post-page';
    $this->load->view('Blog/header',$data);
    $this->load->view('Blog/post',$data);
    $this->load->view('Blog/footer',$data);
  }

  public function _test()
  {
    echo 'test';
    /*$data = array(
      'id'=>5,
      'post_title'=>'test8',
      'post_body'=>'test',
      'post_date'=>'8878789'
    );*/
    //$this->db->delete('posts',$data = ['post_title'=>'asdfasdfasdfasdf']);

    //$this->db->select_max('id');
    //$test = $this->db->get('posts');
    //$this->db->where('id',8);
    //$this->db->delete('posts');
  }


}
