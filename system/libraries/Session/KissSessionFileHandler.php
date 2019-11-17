<?php
class KissSessionFileHandler extends KISS_Session implements SessionHandlerInterface
{
  private $config;
  private $session_id;
  private $file_path;
  private $new_file;

  public function __construct()
  {
    $this->config =& config();
    
    if (isset($this->config['sess_save_path']))
    {
      $this->config['sess_save_path'] = rtrim($this->config['sess_save_path'], '/\\');
      ini_set('session.save_path', $this->config['sess_save_path']);
    }
    else
    {
      $this->config['sess_save_path'] = rtrim(ini_get('session.save_path'), '/\\');
    }
  }
 
  public function open($sess_save_path, $session_name)
  {
    $this->config['sess_save_path'] = $sess_save_path;
    $this->file_path = $this->config['sess_save_path'].DIR.$session_name;
    if ( ! is_dir($sess_save_path) ) {
      if ( ! mkdir($sess_save_path, 0700, TRUE) ) {
        trigger_error("Error - Unable to create directory. Change the 'sess_save_path' setting in your config file or change file permissions.",E_USER_WARNING);
        return FALSE;
      }
    }

    return TRUE;
  }

  public function close()
  {
    $this->session_id = NULL;
    return TRUE;
  }

  public function read($id)
  {
    // To detect session_regenerate_id() calls
    $this->session_id = $id;

    // new_file becomes false
    if ( $this->new_file = ! file_exists($this->file_path.$this->session_id)) {
      file_put_contents("$this->file_path$this->session_id", NULL,LOCK_EX);
    } else {
      return (string)@file_get_contents("$this->file_path$this->session_id");
    }
  }

  public function write($id, $data)
  {
    if ($id !== $this->session_id) {
      if ( ! $this->new_file ) {
        file_put_contents("$this->file_path$id",$data,LOCK_EX);
      }
    }

    return file_put_contents("$this->file_path$id",$data,LOCK_EX) === FALSE ? FALSE : TRUE;
  }

  public function destroy($id)
  {
    $this->_destroy_cookie();
    $file = "$this->file_path$id";
    if (file_exists($file)) {
      unlink($file);
    }

    return TRUE;
  }

  public function gc($maxlifetime)
  {
    echo $this->file_path;
    foreach (glob("$this->file_path*") as $file) 
    {
      var_dump($file);
      $ts = time() - $maxlifetime;
      $mtime = filemtime($file);
      if ( ($mtime > $ts) AND file_exists($file)) {
        unlink($file);
      }
    }

    return TRUE;
  }

}