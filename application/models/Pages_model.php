<?php
defined('BASEPATH') OR exit('Direct script access not allowed');

class Pages_model extends KISS_Model
{

  public function __construct()
  {
  	$this->table = 'posts';
  }





  public function get($order_by) 
  {
    $this->db->order_by($order_by);
    $query = $this->db->get($this->table);
    return $query;
  }

  public function get_with_limit($limit, $offset, $order_by) 
  {
    $this->db->limit($limit, $offset);
    $this->db->order_by($order_by);
    $query = $this->db->get($this->table);
    return $query;
  }

  public function get_where($id) 
  {
    $this->db->where('id', $id);
    $query = $this->db->get($this->table);
    return $query;
  }

  public function get_where_custom($col, $value) 
  {
    $this->db->where($col, $value);
    $query = $this->db->get($this->table);
    return $query;
  }
  
  public function _insert($data) 
  {
    $this->db->insert($this->table, $data);
  }

  public function _update($id, $data) 
  {
    $this->db->where('id', $id);
    $this->db->update($this->table, $data);
  }

  public function _delete($id) 
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);
  }

  public function count_where($column, $value) 
  {
    $this->db->where($column, $value);
    $query = $this->db->get($this->table);
    $num_rows = $query->num_rows();
    return $num_rows;
  }

  public function count_all() 
  {
    $count = $this->db->count_all($this->table);
    return $count;
  }

  public function get_max() 
  {
    $this->db->select_max('id');
    $query = $this->db->get($this->table);
    $row = $query->row();
    $id = $row->id;
    return $id;
  }
  
  public function _custom_query($query, $bind_params = FALSE) 
  {
    $query = $this->db->query($query, $bind_params);
    return $query;
  }

}