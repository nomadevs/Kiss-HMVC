<?php
class KissSessionDBHandler extends KISS_Session implements SessionHandlerInterface
{
  private $db;
  private $config;
  private $session_id;
  private $sess_hash;
  private $has_rows = FALSE;
  private $is_locked = FALSE;

  public function __construct()
  {
    $this->config =& config();
    $db_config =& db_config();
    $db =& load_class('Database','database',$db_config);
    $this->db = $db;
  }

  public function open($sess_save_path, $session_name)
  {
    if ( ! $this->db->is_connected() ) {
      return FALSE;
    }
    $this->validate_id();
    return TRUE;
  }

  public function close()
  {
    return ($this->is_locked AND ! $this->unlock_session()) ? FALSE : TRUE;
  }

  public function read($session_id)
  {
    echo $session_id;
    if ($this->lock_session($session_id) === FALSE)
    {
      return FALSE;
    }

    // Reset query to prevent clashes with other queries
    $this->db->reset_query();

    // To detect session_regenerate_id() calls
    $this->session_id = $session_id;

    $table = $this->db->escape_str($this->config['sess_save_path']);
    $sql = "SELECT data FROM $table WHERE id = ?";

    if ( ! empty($this->config['sess_match_ip']) ) {
      $sql .= "AND WHERE ip_address = ?";
      $query = $this->db->query($sql,[$session_id,$_SERVER['REMOTE_ADDR']]);
    } else {
      $query = $this->db->query($sql,[$session_id]);
    }
    
    if ( $query->num_rows() === 0 )
    {
      $this->has_rows = FALSE;
      $this->sess_hash = md5('');
      return '';
    }

    foreach( $query->result() as $row ) {
      $result = $row->data;
    }

    $this->sess_hash = md5($result);
    $this->has_rows = TRUE;
    return $result;
  }

  public function write($session_id, $data)
  {
    // Reset query to prevent clashes with other queries
    $this->db->reset_query();

    // Was the ID regenerated?
    if (isset($this->session_id) AND $session_id !== $this->session_id)
    {
      if ( ! $this->unlock_session() OR ! $this->lock_session($session_id))
      {
        return FALSE;
      }

      $this->has_rows = FALSE;
      $this->session_id = $session_id;
    }
    elseif ( $this->is_locked === FALSE )
    {
      return FALSE;
    }

    $table = $this->db->escape_str($this->config['sess_save_path']);
    if ( $this->has_rows === FALSE )
    {
      $insert_data = array(
        'id'         => $session_id,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'timestamp'  => time(),
        'data'       => $data
      );
      $this->db->insert($this->config['sess_save_path'], $insert_data);

      $sql = "SELECT * FROM $table WHERE id = ? AND ip_address = ?";
      $query = $this->db->query($sql,[$session_id,$_SERVER['REMOTE_ADDR']]);
      if ( $query->num_rows() > 0 )
      {
        $this->sess_hash = md5($data);
        $this->has_rows = TRUE;
        return TRUE;
      }

      return FALSE;
    }

   if ( $this->sess_hash !== md5($data) )
   {
     $sql = "UPDATE $table SET timestamp = ?, data = ? WHERE id = ?";
   } else {
     $sql = "UPDATE $table SET timestamp = ? WHERE id = ?";
   }
 
    if ( ! empty($this->config['sess_match_ip']) ) {
      $sql .= "AND WHERE ip_address = ?";
      if ( $this->sess_hash !== md5($data) )
      {
        $query = $this->db->query($sql,[time(),$data,$session_id,$_SERVER['REMOTE_ADDR']]);
      }
      else
      {
        $query = $this->db->query($sql,[time(),$session_id,$_SERVER['REMOTE_ADDR']]);
      }
    } else {
      if ( $this->sess_hash !== md5($data) ) {
        $query = $this->db->query($sql,[time(),$data,$session_id]);
      } else {
        $query = $this->db->query($sql,[time(),$session_id]);
      }
    }

    $sql = "SELECT * FROM $table WHERE id = ? AND ip_address = ?";
    $query = $this->db->query($sql,[$session_id,$_SERVER['REMOTE_ADDR']]);
    if ( $query->num_rows() > 0 )
    {
      $this->sess_hash = md5($data);
      return TRUE;
    }

    return FALSE;
  }

  public function destroy($session_id)
  {
    if ( $this->is_locked )
    {
      // Reset query to prevent clashes with other queries
      $this->db->reset_query();

      $table = $this->db->escape_str($this->config['sess_save_path']);
      $sql = "DELETE FROM $table WHERE id = ?"; 
      if ( ! empty($this->config['sess_match_ip']) ) {
        $sql .= "AND WHERE ip_address = ?";
        $query = $this->db->query($sql,[$session_id,$_SERVER['REMOTE_ADDR']]);
      } else {
        $query = $this->db->query($sql,[$session_id]);
      }
      $sql = "SELECT id, ip_address FROM $table WHERE id = ? AND ip_address = ?";
      $query = $this->db->query($sql,[$session_id,$_SERVER['REMOTE_ADDR']]);
      // Did the record delete successfully ?
      if ( $query->num_rows() > 0 )
      {
        return FALSE;
      }
    }

    if ($this->close() === TRUE)
    {
      $this->_destroy_cookie();
      return TRUE;
    }

    return FALSE;
  }

  public function gc($maxlifetime)
  {
    // Reset query to prevent clashes with other queries
    $this->db->reset_query();

    return ($this->db->delete($this->config['sess_save_path'], 'timestamp < '.(time() - $maxlifetime))) ? TRUE : FALSE;
  }

  private function lock_session($session_id) 
  {
    $sess_to_lock = md5($session_id.($this->config['sess_match_ip'] ? '_'.$_SERVER['REMOTE_ADDR'] : ''));

    $query = $this->db->query("SELECT GET_LOCK('".$sess_to_lock."', 300) AS kiss_session_lock")->result_array();
    
      foreach( $query as $key => $lock ) {
        if ( $lock['kiss_session_lock'] === 1 ) {
          $this->is_locked = $sess_to_lock;
          return TRUE;
        }
      }
    
    return FALSE;
  }

  private function unlock_session()
  {
    if ( ! $this->is_locked )
    {
      return TRUE;
    }
    $query = $this->db->query("SELECT RELEASE_LOCK('".$this->is_locked."') AS kiss_session_lock")->result_array();
    foreach( $query as $key => $lock ) {
      if ( $lock['kiss_session_lock'] === 1 ) { 
        $this->is_locked = FALSE;
        return TRUE;
      }
    }
    return FALSE;
  }

  private function validate_session_id($id)
  {
    // Reset query to prevent clashes with other queries
    $this->db->reset_query();
    $table = $this->db->escape_str($this->config['sess_save_path']);
    $sql = "SELECT 1 FROM $table WHERE id = ? ";
    if ( ! empty($this->config['sess_match_ip']) ) {
      $sql .= "AND WHERE ip_address = ?";
      $query = $this->db->query($sql,[$id,$_SERVER['REMOTE_ADDR']]);
    } else {
      $query = $this->db->query($sql,[$id]);
    }

    $result = $query->row();

    if ( ! empty($result) ) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  private function validate_id()
  {
    if (isset($_COOKIE[$this->config['cookie_name']]) AND ! $this->validate_session_id($_COOKIE[$this->config['cookie_name']]))
    {
      unset($_COOKIE[$this->config['cookie_name']]);
    }
  }

}