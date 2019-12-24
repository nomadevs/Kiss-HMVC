<?php
/**
 * Form Helper
 *  
 * Form helper functions.
 *  
 * @package     KissHMVC
 * @subpackage  Helpers
 * @category    Form
 * @author      CitrusDevs
 * @link        https://demo.citrusdevs.x10.bz/kiss-hmvc
 * @copyright   Copyright (c) 2019 CitrusDevs (https://www.citrusdevs.x10.bz/)
 * @copyright   Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/, https://codeigniter.com/)
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @license     MIT License (https://opensource.org/licenses/MIT)
 * @version     1.1.0
 * @todo 
 */
defined('BASEPATH') OR exit('Direct script access not allowed');

/**
 * Form open tag
 *
 * @param   string $action
 * @param   array  $attributes
 * @return  string
 */
function form_open( $action = NULL, $attributes = array() )
{
  $action = strtolower($action);
  $controller = get_instance()->request->_segment(1);
  $_action = get_instance()->request->_segment(2);
  if ( $action == NULL OR $action == '' ) {
    echo $_action;
    $action = base_url($controller.FS.$_action);
  } else {
    $count = explode('/',$action);
    if( count($count) < 2 ) {
      $action = base_url($controller.FS.$action);
    } else {
      $action = base_url($action);
    }
  }
  if ( ! isset($attributes['method'] ) ) {
    $method = ['method'=>'POST'];
    $attributes = array_merge($attributes, $method);
  }
  $attrs = _attributes_to_string($attributes);
  return '<form action="'.$action.'"'.$attrs.'>';
}

/**
 * Form close tag
 *
 * @param   void
 * @return  string
 */
function form_close()
{
  return '</form>';
}

/**
 * Form errors
 *
 * Helper function for custom errors. You can set optional delimiters by passing in tags as a second parameter. The first parameter specifies a form field for form validation to target.

 * @param   string $field
 * @param   string $prefix (optional)
 * @param   string $suffix (optional)
 * @return  string
 */
function form_error( $field = '', $prefix = '<p>', $suffix = '</p>')
{
  if (empty($_SESSION[$field]['error_msg']))
  {
    return '';
  } else {
    $error_prefix = get_instance()->Form_validation->_get_error_prefix();
    $error_suffix = get_instance()->Form_validation->_get_error_suffix();

    $prefix = ($error_prefix) ? $error_prefix : $prefix;
    $suffix = ($error_suffix) ? $error_suffix : $suffix;

    $error_msg = $prefix.$_SESSION[$field]['error_msg'].$suffix;
    unset($_SESSION[$field]);
    return $error_msg;  
  }
}

/**
 * Validation Errors
 *
 * Display errors
 * 
 * @param   string $prefix (optional)
 * @param   string $suffix (optional)
 * @return  string
 */
function validation_errors($prefix = '<p>', $suffix = '</p>')
{
  if ( isset($_SESSION['form_errors']) ) {

    $error_prefix = get_instance()->Form_validation->_get_error_prefix();
    $error_suffix = get_instance()->Form_validation->_get_error_suffix();

    $prefix = isset($error_prefix) ? $error_prefix : $prefix;
    $suffix = isset($error_suffix) ? $error_suffix : $suffix;

    foreach( $_SESSION['form_errors'] as $form_error ) {
      $form_error = $prefix.$form_error.$suffix;
    }
    unset($_SESSION['form_errors']);
    return $form_error;
  }
}


/**
 * Form input
 *
 * @param  mixed  $data
 * @param  string $value 
 * @param  array  $extra (optional) 
 * @return  string
 */
function form_input( $data = NULL, $value = NULL, $extra = array() )
{
  if ( ! is_array($data) ) {
    $data = [
      'type'  => 'text',
      'value' => $value,
      'name'  => $data
    ];
  } 
  // Make sure input type is text by default with option to change
  $data = array_merge($data,['type'=> isset($data['type']) ? $data['type'] : 'text']);
  if ( isset($extra) ) {
    $data = array_merge($data, $extra);
  }
  $attrs = _attributes_to_string($data);
  return '<input '.$attrs.' />';
}

/**
 * Form submit
 *
 * @param   mixed  $data, 
 * @param   string $value, 
 * @param   array  $extra (optional) 
 * @return  string
 */
function form_submit( $data = NULL, $value = NULL, $extra = array() )
{
  if ( ! is_array($data) ) {
    $data = [
      'type'  => 'submit',
      'value' => $value,
      'name'  => $data
    ];
  } 
  // Make sure input type is submit by default with option to change
  $data = array_merge($data,['type'=> isset($data['type']) ? $data['type'] : 'submit']);
  if ( isset($extra) ) {
    $data = array_merge($data, $extra);
  }
  $attrs = _attributes_to_string($data);
  return '<input '.$attrs.' />';
}

/**
 * Form reset
 *
 * @param   mixed  $data, 
 * @param   string $value, 
 * @param   array  $extra (optional) 
 * @return  string
 */
function form_reset( $data = NULL, $value = NULL, $extra = array() )
{
  if ( ! is_array($data) ) {
    $data = [
      'type'  => 'reset',
      'value' => $value,
      'name'  => $data
    ];
  } 
  // Make sure input type is reset by default with option to change
  $data = array_merge($data,['type'=> isset($data['type']) ? $data['type'] : 'reset']);
  if ( isset($extra) ) {
    $data = array_merge($data, $extra);
  }
  $attrs = _attributes_to_string($data);
  return '<input '.$attrs.' />';
}

/**
 * Form textarea
 *
 * @param   mixed  $data, 
 * @param   string $value, 
 * @param   array  $extra (optional)  
 * @return  string
 */
  function form_textarea($data = NULL, $value = NULL, $extra = array())
  {
    if ( ! is_array($data) ) {
      $data = [
        'name'  => $data,
        'cols' => '40',
        'rows' => '10'
      ];
      $val = $value;
    } 
    if ( isset($extra) ) {
      $data = array_merge($data, $extra);
    }
    $_value = isset($data['value']) ? $data['value'] : NULL;
    $value =  isset($val) ? $val : $_value;
    unset($data['value']);
    return '<textarea '._attributes_to_string($data).'>'.htmlspecialchars($value, ENT_QUOTES, 'UTF-8', TRUE)."</textarea>\n";
  }

/**
 * Array to string
 *
 * Converts an array to a string.
 * 
 * @param   mixed  $attributes
 * @return  mixed
 */
function _attributes_to_string($attributes)
{
  if (empty($attributes))
  {
    return '';
  }

  if (is_array($attributes))
  {
    $atts = '';

    foreach ($attributes as $key => $val)
    {
      $atts .= ' '.$key.'="'.$val.'"';
    }

    return $atts;
  }

  if (is_string($attributes))
  {
    return ' '.$attributes;
  }

  return FALSE;
}


