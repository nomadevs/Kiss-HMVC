<?php
/**
 * Form Validation Class
 *  
 * Sanitizes and preps form data.
 *  
 * @package     KissHMVC
 * @subpackage  Libraries
 * @category    Form validation
 * @author      CitrusDevs
 * @link        https://demo.citrusdevs.x10.bz/kiss-hmvc
 * @copyright   Copyright (c) 2019 CitrusDevs (https://www.citrusdevs.x10.bz/)
 * @copyright   Copyright (c) 2019, Redhorn Development, David Connelly (https://trongate.io/, https://speedcodingacademy.com/)
 * @copyright   Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/, https://codeigniter.com/)
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @license     MIT License (https://opensource.org/licenses/MIT)
 * @version     1.1.0
 * @todo        
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

class KISS_Form_validation 
{
  private $KISS;
  private $form_errors     = array();
  private $custom_errors   = array();
  private $error_prefix;
  private $error_suffix;
  private $field;

  public function __construct()
  {
    $this->KISS =& get_instance();
  
    // Load the form helper
    $this->KISS->load->helper('form');
  }

  public function set_rules($field = '', $label = '', $rules = '', $errors = array())
  {
    $_field = array($field);
    foreach($_field as $fields) {
      $this->field[] = $fields;
    }

    // Custom errors
    if ( ! empty($errors) AND is_array($errors) ) {
      $this->set_message($errors);
    } 

      // Config
      if ( is_array($field) ) {
        foreach( $field as $rule ) 
        {
          $field = isset($rule['field']) ? $rule['field'] : $rule['field'];
          $label = isset($rule['label']) ? $rule['label'] : $field;
          $rules = isset($rule['rules']) ? $rule['rules'] : $rule['rules'];
          $errors =  (isset($rule['errors']) AND is_array($rule['errors'])) ? $rule['errors'] : array();

          $this->set_rules($field, $label, $rules, $errors);
        }
      } else {
        $postdata = $this->KISS->input->post($field,TRUE);
        $field = (isset($postdata) AND !empty($postdata)) ? $postdata : NULL;

        foreach( $this->get_rules($rules) as $rule )
        {       
          $callback = '';
          if ( strpos($rule, 'callback_') !== FALSE ) {
            $callback = explode('callback_',$rule);
            foreach( $callback as $cb ) {
              if ( $cb !== '' AND method_exists($this->KISS, $cb) ) {
                $callback = $cb;
              }
            }
          }
          
          if ( $rule == 'callback_'.$callback ) {
            call_user_func_array(array($this,'callback'),array($callback,$field,$label));
          } else {
            call_user_func_array(array($this,$rule),array($field,$label));
          }
          
        }
      }
    
  }

  public function get_rules($rules)
  {
    $rule = explode('|',$rules);
    return $rule;
  }

  private function valid_email($field = '', $label = '') 
  {
    if ( ( ! filter_var($field, FILTER_VALIDATE_EMAIL) ) AND ( $field == '' ) ) {
      if ( isset($this->custom_errors['valid_email']) ) {
        $this->form_errors[] = $this->_error_placeholders($label,$this->custom_errors['valid_email']);
      } else {
        $this->form_errors[] = 'The '.$label.' field must contain a valid email address.';
      }
    }
  }

  private function required($field = '', $label = '')
  {
    if ( $field == '')  {  
      if ( isset($this->custom_errors['required']) ) {
        $this->form_errors[] = $this->_error_placeholders($label,$this->custom_errors['required']);
      } else {
        $this->form_errors[] = 'The '.$label.' field is required.';
      }
    }
  }

  private function xss_clean($field = '', $label = '')
  {
     echo 'xss_clean';
  }


  public function run($validation = NULL) 
  {
    if ( file_exists( APPPATH.'config'.DIR.'form_validation'.PHPXTNSN ) ) {
      require_once APPPATH.'config'.DIR.'form_validation'.PHPXTNSN;

      if ( isset($config[$validation]) ) {
        $this->set_rules($config[$validation]);
      } elseif ( isset($config) )  {
        $this->set_rules($config);
      } else {
        // Don't load anything because rules are set in a controller not a config file!
      }
    }

    if (isset($_SESSION['form_errors'])) {
      unset($_SESSION['form_errors']);
    }

 
    if ( (count($this->form_errors) > 0) ) {
      $i = 0;
      foreach( $this->field as $field ) {
        if (isset($_SESSION[$this->field[$i]])) {
          unset($_SESSION[$this->field[$i]]);
        }
        $_SESSION[$this->field[$i]]['error_msg'] = $this->_error_placeholders($this->field[$i],$this->form_errors);
        $i++;
      }

      $_SESSION['form_errors'] = $this->form_errors;
      return FALSE;
    } else {
      return TRUE;
    }

  }

  public function callback( $target_rule = '', $field = '', $label = '' )
  {
    if ( method_exists($this->KISS, $target_rule) ) {
      $result = $this->KISS->{$target_rule}($field);
      if ( $result === FALSE AND $field == '' ) {
        if ( isset($this->custom_errors[$target_rule]) ) {
          $this->form_errors[] = $this->_error_placeholders($label,$this->custom_errors[$target_rule]);
        } else {
          $this->form_errors[] = 'Callback &mdash; The '.$label.' field is required.';
        }
      } 
    }
  }

  public function set_message($target_rule = '', $error_msg = '')
  {
    if ( is_array($target_rule) )
    {
      foreach( $target_rule as $_rule => $_error_msg ) {
        $this->custom_errors[$_rule] = $_error_msg;
      }
      return;
    }

    $this->custom_errors[$target_rule] = $error_msg;
  }

  private function _error_placeholders($label = '',$str = '')
  {
    if ( is_array($str) ) {
      $str = array_values($str);
      $str = $str[0];
    } 
    // Check for %s in the string
    if (strpos($str, '%s') !== FALSE)
    {
      return sprintf($str,$label);
    }
    // Check for curly brace placeholders
    return str_replace(array('{label}'), array($label), $str);
  }

  public function set_error_delimiters($prefix = '<p>', $suffix = '</p>')
  {
    $this->error_prefix = $prefix;
    $this->error_suffix = $suffix;
    return $this;
  }

  public function _get_error_prefix()
  {
    return $this->error_prefix;
  }

  public function _get_error_suffix()
  {
    return $this->error_suffix;
  }

}