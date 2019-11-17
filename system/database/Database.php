<?php
/**
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019, CitrusDevs
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * KissHMVC Database Class
 *  
 * Database results, query building, etc.
 *  
 * @package     KissHMVC
 * @subpackage  Database
 * @category    Database
 * @author      CitrusDevs
 * @link        https://demo.citrusdevs.x10.bz/kiss-hmvc
 * @copyright	Copyright (c) 2019 CitrusDevs (https://www.citrusdevs.x10.bz/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/, https://codeigniter.com/)
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @license     MIT License (https://opensource.org/licenses/MIT)
 * @version     1.1.0
 * @todo        
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class KISS_Database extends MYSQLI
{
  private $db;
  private $query;
  private $all_queries    = array();
  private $result_object  = array();
  private $result_array   = array();
  private $num_rows;
  private $select_max;
  private $where;
  private $select;
  private $table;
  private $limit;
  private $order_by;
  private $is_connected = FALSE;

  public function __construct($config = array())
  {
    $db_config =& db_config();
    if ( ! empty($config) ) {
      $db_host = isset($config['db_host']) ? $config['db_host'] : 'localhost';
      $db_user = isset($config['db_user']) ? $config['db_user'] : 'root';
      $db_pass = isset($config['db_pass']) ? $config['db_pass'] : '';
      $db_name = isset($config['db_name']) ? $config['db_name'] : '';
    } else {
      $db_host = isset($db_config['db_host']) ? $db_config['db_host'] : 'localhost';
      $db_user = isset($db_config['db_user']) ? $db_config['db_user'] : 'root';
      $db_pass = isset($db_config['db_pass']) ? $db_config['db_pass'] : '';
      $db_name = isset($db_config['db_name']) ? $db_config['db_name'] : '';
    }
    parent::__construct($db_host, $db_user, $db_pass, $db_name);
/*    if ( $this->_is_connected() === FALSE ) {
      $this->is_connected = FALSE;
    } else {
      $this->is_connected = TRUE;
    }*/
    $this->is_connected = TRUE;
  }

  public function is_connected()
  {
    return $this->is_connected;
  }

  private function _is_connected()
  {
    $sql  = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS";
    $query = $this->query($sql);
    if ( empty($query->error) ) {
      foreach( $query->result() as $row ) {
        if ( $row->TABLE_SCHEMA ) {
          return TRUE;
        } else {
          return FALSE;
        }
      }
    // Reset query to prevent clashes with other queries
    $this->db->reset_query();
    } else {
      return FALSE;
    }
  }

  public function query($sql = NULL, $bind_params = FALSE) 
  {   
    $this->all_queries[] = $this->query = $sql;
    if ($bind_params === FALSE) {
      parent::query($this->query);
      return $this; // Allows for chaining methods
    } else {
      $this->query = $this->compile_binds($sql, $bind_params);
      return $this;
    } 
  }

  public function select($select = '')
  {
    if (is_string($select))
    {
      $select = explode(',', $select);
    }

    foreach ($select as $val)
    {
      $val = trim($val);

      if ($val !== '')
      {
        $this->select = $select ? $select = 'SELECT '.$val : $select = 'SELECT * ';
      }
    }

    return $this;
  }



  public function from($from = '')
  {
    foreach ((array) $from as $val)
    {
      if (strpos($val, ',') !== FALSE)
      {
        foreach (explode(',', $val) as $v)
        {
          $v = trim($v);
          $this->table = 'FROM '.$v;
        }
      }
      else
      {
        $val = trim($val);
        $this->table = 'FROM '.$val;
      }
    }
    return $this;
  }

  public function get($table = '', $limit = NULL, $offset = 0)
  {

    // Builds full sql statement
    $this->select   = $this->select ? $this->select : 'SELECT * ';
    $this->table    = $this->table ? $this->table : ' FROM '.$table . ' ';
    $this->order_by = $this->order_by ? $this->order_by : 'ORDER BY id DESC ';
    $sql = ( $this->select_max ? $this->select_max : $this->select ) . $this->table . $this->where . $this->order_by . $this->limit;
    //echo $sql;
    if ( isset($limit) AND isset($offset) ) {
      $this->limit = $limit ? ' LIMIT ?,?' : NULL;
      return $this->query($sql,[$limit,$offset]);
    } else {
      return $this->query($sql);
    }
  }

  public function order_by($orderby,$order = 'DESC')
  {
    return $this->_orderby_stmt($orderby,$order);
  }

  private function _orderby_stmt($orderby,$order)
  {
    $this->order_by = ' ORDER BY '.$orderby. ' '.$order;
    return $this->order_by;
  }

  public function limit($limit,$offset = 0)
  {
    return $this->_limit_stmt($limit,$offset);
  }

  private function _limit_stmt($limit,$offset)
  {
    $limit = $this->escape($limit);
    $offset = $this->escape($offset);
    $this->limit = ' LIMIT '.$limit.','.$offset;
    return $this->limit;
  }

  public function where($key, $value = NULL)
  {
    if ( is_array($key) )
    {
      foreach($this->escape($key) as $k=>$v) // Sanitize array
      { 
        $where_data[$k] = $v;
      }
      $sql = $this->_where_stmt($where_data);
      return $this->query($sql);
    }
    $sql = $this->_where_stmt($key,$value);
    return $this->query($sql);
  }

  private function _where_stmt($keys, $values = NULL)
  {
    if ( is_array($keys) AND empty($values) ) {
      foreach( $keys as $key => $val ) {
        $vals[] = $key.' = '.$val.' ';
      }
      $this->where = ' WHERE '.implode(', ', $vals);
      return $this->where;
    }
    $this->where =  ' WHERE '.$keys.' = '.$values.' ';
    return $this->where;
  }

  public function insert($table, $data)
  {
    if ( is_array($data) )
    {
      foreach($this->escape($data) as $key=>$val) // Sanitize array
      { 
        $insert_data[$key] = $val;
      }
      $sql = $this->_insert_stmt($table,array_keys($insert_data),array_values($insert_data));
      return $this->query($sql);
    }
    
  }

  public function update($table, $data)
  {
    if ( is_array($data))
    {
      foreach($this->escape($data) as $key=>$val) // Sanitize array
      { 
        $update_data[$key] = $val;
      }
      $sql = $this->_update_stmt($table,$update_data);
      return $this->query($sql);
    }
  }

  public function delete($table, $where = '')
  {
    if ( is_array($where) ) {
      foreach ($where as $key => $val)
      {
        $key = $this->escape_identifiers($key);
        $val = $this->escape($val);
        $table = $this->escape_identifiers($table);
        $delete_data[$key] = $val;
      }
      $sql = $this->_delete_stmt($table,$delete_data);
      //echo $sql;
      return $this->query($sql);
    }
    $table = $this->escape_identifiers($table); 
    $sql = $this->_delete_stmt($table);
    return $this->query($sql);
  }

  public function last_query()
  {
    return end($this->all_queries);
  }

  public function reset_query()
  {
    $this->select_max = NULL;
    $this->where      = NULL;
    $this->select     = NULL;
    $this->table      = NULL;
    $this->limit      = NULL;
    $this->order_by   = NULL;
  }

  public function count_all($table)
  {
    if ($table === '')
    {
      return 0;
    }
    $sql = "SELECT * FROM $table";
    $query = $this->query($sql);
    if ($query->num_rows() === 0)
    {
      return 0;
    }
    return (int) $this->num_rows;
  }

  public function select_max($select = '', $alias = '')
  {
    if ( $select !== '' ) {
      if ($alias === '')
      {
        $alias = trim($select);
      }  
      $sql = 'SELECT MAX('.trim($select).') AS '.trim($alias);
      $this->select_max = $sql;
      return $this->select_max;
    }
    return;
  }

  /**
   * ===================================
   *   Running Queries and Getting Results
   * ===================================
   */

  /**
   * Result Object
   *
   * Returns a result as an object.
   * 
   * @todo   
   * @param
   * @return object
   */
  public function result()
  {  
    if ($result = parent::query($this->query)) {
      /* Fetch object */
      while ($row = $result->fetch_object())
      {
        $this->result_object[] = $row;
      }
      return $this->result_object;
    }
  }

  /**
   * Row Object
   *
   * Returns a row as an object.
   * 
   * @todo   
   * @param
   * @return object
   */
  public function row($num = 0)
  {
    $result = $this->result();
    if (count($result) == 0)
    {
      return NULL;
    }
    if ( isset($result[$num]) ) {
      return $result[$num];
    }
  }

  /**
   * Result Array
   *
   * Returns a result as an array.
   * 
   * @todo   
   * @param
   * @return array
   */
  public function result_array()
  {
    if ($result = parent::query($this->query)) {

      /* Fetch associative array */
      while ($row = $result->fetch_assoc()) {
        $this->result_array[] = $row;
      }
      return $this->result_array;
    }
  }

  /**
   * Row Array
   *
   * Returns a single row as an array.
   * 
   * @todo   
   * @param
   * @return array
   */ 
  public function row_array($num = 0)
  {
    if ( is_numeric($num)  ) {
      $result = $this->result_array();
      if (count($result) == 0)
      {
        return NULL;
      }
      if ( isset($result[$num]) ) {
        return $result[$num];
      }
    }
  }

  /**
   * Num Rows
   *
   * Returns the row count.
   * 
   * @todo   
   * @param
   * @return int
   */
  public function num_rows()
  {
    if (is_int($this->num_rows))
    {
      return $this->num_rows;
    }
    elseif (count($this->result_array) > 0)
    {
      return $this->num_rows = count($this->result_array);
    }
    return $this->num_rows = count($this->result_array());
  }

  /**
   * CodeIgniter's CI_DB_driver Class
   * 
   * Compiles bind parameters for prepared statement.
   */
  private function compile_binds($sql, $binds)
  {
    if ( ! is_array($binds))
    {
      $binds = array($binds);
      $bind_count = 1;
    }
    else
    {
      // Make sure we're using numeric keys
      $binds = array_values($binds);
      $bind_count = count($binds);
    }

    // We'll need the marker length later
    $ml = strlen('?');

    // Make sure not to replace a chunk inside a string that happens to match the bind marker
    if ($c = preg_match_all("/'[^']*'|\"[^\"]*\"/i", $sql, $matches))
    {
      $c = preg_match_all('/'.preg_quote('?', '/').'/i',
        str_replace($matches[0],
          str_replace('?', str_repeat(' ', $ml), $matches[0]),
          $sql, $c),
        $matches, PREG_OFFSET_CAPTURE);

      // Bind values' count must match the count of markers in the query
      if ($bind_count !== $c)
      {
        return $sql;
      }
    }
    elseif (($c = preg_match_all('/'.preg_quote('?', '/').'/i', $sql, $matches, PREG_OFFSET_CAPTURE)) !== $bind_count)
    {
      return $sql;
    }

    do
    {
      $c--;
      $escaped_value = $this->escape($binds[$c]);
      if (is_array($escaped_value))
      {
        $escaped_value = '('.implode(',', $escaped_value).')';
      }
      $sql = substr_replace($sql, $escaped_value, $matches[0][$c][1], $ml);
    }
    while ($c !== 0);

    return $sql;

  }

  public function escape($str)
  {
    if (is_array($str))
    {
      $str = array_map(array($this, 'escape'), $str);
      return $str;
    }
    elseif (is_string($str))
    {
      return "'".$this->escape_str($str)."'";
    }
    elseif ($str === NULL)
    {
      return 'NULL';
    }
    return $str;
  }

  public function escape_str($str, $like = FALSE)
  {
    if (is_array($str))
    {
      foreach ($str as $key => $val)
      {
        $str[$key] = $this->escape_str($val, $like);
      }

      return $str;
    }

    $str = $this->_escape_str($str);

    // Escape LIKE condition wildcards
    if ($like === TRUE)
    {
      return str_replace(
        array('!', '%', '_'),
        array('!!', '!%', '!_'),
        $str
      );
    }

    return $str;
  }


  private function _escape_str($str)
  {
    return str_replace("'", "''", trim($str));
  }


  public function escape_identifiers($item)
  {
    $this->_escape_char = '`'; //'"'
    if ($this->_escape_char === '' OR empty($item) OR in_array($item, array('*')))
    {
      return $item;
    }
    elseif (is_array($item))
    {
      foreach ($item as $key => $value)
      {
        $item[$key] = $this->escape_identifiers($value);
      }

      return $item;
    }
    // Avoid breaking functions and literal values inside queries
    elseif (ctype_digit($item) OR $item[0] === "'" OR ($this->_escape_char !== '"' && $item[0] === '"') OR strpos($item, '(') !== FALSE)
    {
      return $item;
    }

    static $preg_ec = array();

    if (empty($preg_ec))
    {
      if (is_array($this->_escape_char))
      {
        $preg_ec = array(
          preg_quote($this->_escape_char[0], '/'),
          preg_quote($this->_escape_char[1], '/'),
          $this->_escape_char[0],
          $this->_escape_char[1]
        );
      }
      else
      {
        $preg_ec[0] = $preg_ec[1] = preg_quote($this->_escape_char, '/');
        $preg_ec[2] = $preg_ec[3] = $this->_escape_char;
      }
    }

    foreach (array('*') as $id)
    {
      if (strpos($item, '.'.$id) !== FALSE)
      {
        return preg_replace('/'.$preg_ec[0].'?([^'.$preg_ec[1].'\.]+)'.$preg_ec[1].'?\./i', $preg_ec[2].'$1'.$preg_ec[3].'.', $item);
      }
    }

    return preg_replace('/'.$preg_ec[0].'?([^'.$preg_ec[1].'\.]+)'.$preg_ec[1].'?(\.)?/i', $preg_ec[2].'$1'.$preg_ec[3].'$2', $item);
  }



  private function _insert_stmt($table, $keys, $values)
  {
    return 'INSERT INTO '.$table.' ('.implode(', ', $keys).') VALUES ('.implode(', ', $values).')';
  }

  private function _update_stmt($table, $data)
  {
    foreach ($data as $key => $val)
    {
      $vals[] = $key.' = '.$val;
    }
    return 'UPDATE '.$table.' SET '.implode(', ', $vals) . $this->where;
  }

  private function _delete_stmt($table,$where = NULL)
  {
    if ( isset($table) AND $where == NULL ) {
      return 'DELETE FROM ' . $table . $this->where;
    } elseif ( isset($table) AND is_array($where) ) {
      foreach( $where as $key => $val ) {
        $vals[] = $key.' = '.$val;
      }
      return 'DELETE FROM '.$table.' WHERE '.implode(', ', $vals);
    }
  }

}