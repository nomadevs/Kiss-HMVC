<?php defined('BASEPATH') OR exit('Direct script access not allowed');

class KISS_Custom_Dates 
{

  public function __construct(){}
  
  public function get_nice_date($timeStamp,$dateFormat)
  {
    //Takes a unix timestamp and converts it to a nice date
    switch($dateFormat)
    {
      case 'test' :
      // testing
      $date = date('l \t\h\e jS \a\t\ gA',$timeStamp);
      break;
      case 'neat_date_time' :
      // Example: Sunday the 30th at 7PM
      $date = date('l \t\h\e jS \a\t\ gA',$timeStamp);
      break;
      case 'full_shorter' :
      // Example: Dec 30, '18
      $date = date('M j, \'y',$timeStamp);
      break;
      case 'full_short' :
      // Example: Dec 30, 2018
      $date = date('M j, Y',$timeStamp);
      break;
      case 'full_date' :
      // Example: Sunday, December 30th, 2018
      $date = date('l, F jS, Y',$timeStamp);
      break;
      case 'full_date_two' :
      // Example: December 30th, 2018
      $date = date('F jS, Y',$timeStamp);
      break;
      case 'full_date_time' :
      // Example: December 30th, 2018 on Sunday at 4:03 PM
      $date = date('F jS, Y \o\n l \a\t g:i A',$timeStamp);
      break;
      case 'mini_date_hyphen' :
      // Example: 12-30-18
      $date = date('m\-d\-y',$timeStamp);
      break;
      case 'mini_date_slash' :
      // Example: 12/30/18
      $date = date('m\/d\/y',$timeStamp);
      break;
      case 'mini_date_period' :
      // Example: 12.30.18
      $date = date('m\.d\.y',$timeStamp);
      break;	  
    }
	
    if ( $timeStamp == 0 ) {
      return $date = '&mdash;';		  
    } else {
      return $date;
    }
	
  }
  
  
  

}