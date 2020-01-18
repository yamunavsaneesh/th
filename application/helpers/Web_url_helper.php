<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
  * Site URL
  * Used when creating internal anchors, translates a uri into the current language
  */
 function site_url($uri = '')
 {
 	$CI =& get_instance();
 	return $CI->config->site_url($uri);
 }
 function sanitizeStringForUrl($string){
     $string = trim(strtolower($string));
     $string = html_entity_decode($string);
     $string = str_replace(array('ä','ü','ö','ß'),array('ae','ue','oe','ss'),$string);
     $string = preg_replace('#[\s]{2,}#',' ',$string);	
     $string = str_replace(array(' '),array('-'),$string);
     return $string;
 }
 function site_base_url($uri = '')
 {
 	$CI =& get_instance();
 	$url = substr($CI->config->site_url($uri), 0, - 5);
 	return $url;
 }
 //* End of file Alpha_url_helper.php */
 /* Location: ./application/helpers/Alpha_url_helper.php */