<?php
defined('BASEPATH') OR exit('Direct script access not allowed');

class Pages extends KISS_Controller
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
    // need to load other core classes in bootstrap file so I can just reference them like this =& 
    $this->load->model('Pages_model');
    $this->model = $this->Pages_model;
  	$this->load->helper(array('url','form','html'));
    echo $this->session->flashdata('test8');
    //echo $this->input->cookie('cookie_test',TRUE);
    
    $this->load->library('Form_validation');
    $cookie = array(
        'name'   => 'cookie_test',
        'value'  => 'asldfjlkjasdf89879',
        'expire' => 86400,
        'secure' => FALSE
    );
   // $this->input->set_cookie($cookie);
   

    //echo form_error('test','<p>','</p>');
    //var_dump($this->get_where(2));
    //echo '<br>'.$this->get_max();
    // $query = $this->get('id');
    // foreach( $query->result() as $row ) {
    //   echo $row->post_title;
    // }
     // $query = $this->_custom_query("SELECT * FROM posts WHERE id = ?",[10]);
     // foreach($query->result() as $row )
     // {
     //  echo $row->post_title;
     // }
    // $data = array(
    //   'post_title' => 'test',
    //   'post_body' => 'test body',
    //   'post_date' => time(),
    //   'post_slug' => 'test'
    // );
    //  $this->_insert($data);
    //$this->_update(9,array('post_title'=>'new title'));
    $this->db->delete('posts',array('id'=>15));
    //echo '<br>'.$this->count_all();
  }

  public function index()
  {

  }


  public function view($page = 'home')
  {
    $username = $this->input->post('username',TRUE);
    //SQL Injection Test #1
    $sql = "SELECT * FROM users WHERE username = ?";
    $num_rows = $this->_custom_query($sql, [$username])->num_rows();
    echo '<br><h1># Rows Returned: '.$num_rows.'</h1>';
    
    //SQL Injection Test #2
    $num_rows = $this->get_where_custom('username',$username)->num_rows();
    echo '<br><h1># Rows Returned: '.$num_rows.'</h1>';
    $data['site_title'] = 'Home page';
    $data['page_title'] = 'Page Controller';
    $data['body_class'] = 'home-page';
   // $this->Form_validation->set_message('test','Callback - The {label} field is empty.');
    //$this->Form_validation->set_rules('username', 'Username', 'xss_clean|required',['required'=>'testttttt {label}']);//callback_test
    $this->Form_validation->set_rules('username', 'Username', 'xss_clean|callback_test');
    $this->Form_validation->set_rules('email', 'Email', 'xss_clean|required');
    //$this->Form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');

    

    if ( ! $this->Form_validation->run() === FALSE ) {
      $this->load->view('header',$data);
      $this->load->view($page,$data);
      $this->load->view('footer',$data);   
      //redirect('test');
    } else {
      $this->load->view('header',$data);
      $this->load->view($page,$data);
      $this->load->view('footer',$data);
    }
    
  }

  public function _test2(){}

  public function test($test ='')
  {
    if ( $test !== '' AND $test !== NULL ) {
      return true;
    } else {
      return false;
    }
  }

  public function get($order_by) 
  {
    $query = $this->model->get($order_by);
    return $query;
  }

  public function get_with_limit($limit, $offset, $order_by) 
  {
    $query = $this->model->get_with_limit($limit, $offset, $order_by);
    return $query;
  }

  public function get_where($id) 
  {
    $query = $this->model->get_where($id);
    return $query;
  }

  public function get_where_custom($col, $value) 
  {
    $query = $this->model->get_where_custom($col, $value);
    return $query;
  }

  public function _insert($data) 
  {
    $this->model->_insert($data);
  }

  public function _update($id, $data) 
  {
    $this->model->_update($id, $data);
  }

  public function _delete($id) 
  {
    $this->model->_delete($id);
  }

  public function count_where($column, $value) 
  {
    $count = $this->model->count_where($column, $value);
    return $count;
  }

  public function count_all() 
  {
    $count = $this->model->count_all();
    return $count;
  }

  public function get_max() 
  {
    $max_id = $this->model->get_max();
    return $max_id;
  }

  public function _custom_query($query, $bind_params = FALSE) 
  {
    $query = $this->model->_custom_query($query, $bind_params);
    return $query;
  }

}