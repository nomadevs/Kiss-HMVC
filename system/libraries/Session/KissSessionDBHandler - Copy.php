<?php
class KissSessionDBHandler extends KISS_Session implements SessionHandlerInterface
{
  private $db;
  private $config;
  private $session_id;
  private $sess_hash;
  private $has_rows = FALSE;
  private $temp_path;

  public function __construct()
  {
    $this->config =& config();
    $db_config =& db_config();
    $db =& load_class('Database','database',$db_config);
    $this->db = $db;
  }

  public function open($sess_save_path, $session_name)
  {
    $this->temp_path = $sess_save_path.DIR.$session_name;
    echo $this->temp_path.'<br>';
    echo $sess_save_path. '<br>';
    if ( is_dir($sess_save_path) ) {
      return TRUE;
    }
    if ( $this->db->is_connected() === FALSE ) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function close()
  {
  	return TRUE;
  }

  public function read($id)
  {
    // To detect session_regenerate_id() calls
    $this->session_id = $id;
    $table = $this->db->escape_str($this->config['sess_save_path']);
    $sql = "SELECT data FROM $table WHERE id = ?";
    if ( ! empty($this->config['sess_match_ip']) ) {
      $sql .= "AND WHERE ip_address = ?";
      $query = $this->db->query($sql,[$id,$_SERVER['REMOTE_ADDR']]);
      if ( $query->num_rows() < 1 ) {
        $this->has_rows = FALSE;
      }
    } else {
      $query = $this->db->query($sql,[$id]);
      if ( $query->num_rows() < 1 ) {
        $this->has_rows = FALSE;
      }
    }

    /*foreach( $query->result() as $row ) {
      $result = $row->data;
      $this->has_rows = TRUE;
      return $result;
    }*/
    echo $this->temp_path.$id;
     return (string)@file_get_contents("$this->temp_path$id");

  }

  public function write($id, $data)
  {
    if ( isset($this->session_id) AND $id !== $this->session_id )
    {
      $this->session_id = $id;
    }

    file_put_contents("$this->temp_path$id",$data,LOCK_EX);

    if ( $this->has_rows === FALSE ) {
      $insert_data = array(
        'id'         => $id,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'timestamp'  => time(),
        'data'       => $data
      );
      $query = $this->db->insert($this->config['sess_save_path'], $insert_data);
      return ($query) ? TRUE : FALSE;
    } else {
      $update_data = array(
        'timestamp' => time(),
        'data'      => $data
      );
      $query = $this->db->update($this->config['sess_save_path'], $update_data);
      return ($query) ? TRUE : FALSE;
    }

  }

  public function destroy($id)
  {
    //if ( $this->close() === TRUE )
    //{
      $this->_destroy_cookie();
    //}
    $table = $this->db->escape_str($this->config['sess_save_path']);
    $sql = "DELETE FROM $table WHERE id = ?";

     if ( $this->config['sess_match_ip'] === TRUE ) {
     	$sql .= "AND WHERE ip_address = ?";
     	$query = $this->db->query($sql,[$id,$_SERVER['REMOTE_ADDR']]);
        return ($query) ? TRUE : FALSE;
     } else {
       $query = $this->db->query($sql,[$id]);
       return ($query) ? TRUE : FALSE;
     }
  }

  public function gc($maxlifetime)
  {
    $table = $this->db->escape_str($this->config['sess_save_path']);
    $sql = "DELETE FROM $table WHERE timestamp < ?";

    $query = $this->db->query($sql,[$id,(time() - $maxlifetime)]);
    return ($query) ? TRUE : FALSE;
  }	

}