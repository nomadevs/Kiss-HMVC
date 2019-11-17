<?php
defined('BASEPATH') OR exit('Direct script access not allowed');

interface SessionHandlerInterface 
{

	public function open($save_path, $name);
	public function close();
	public function read($session_id);
	public function write($session_id, $session_data);
	public function destroy($session_id);
	public function gc($maxlifetime);
}