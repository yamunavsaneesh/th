<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n 
// version 10 - May 10, 2012

class Web_Config extends CI_Config {

	
	function _site_url($uri = '')
	{	
		$suffix_needed=false;
		if (is_array($uri))
		{
			$uri = implode('/', $uri);
		}
		
		if (class_exists('CI_Controller'))
		{
			$CI =& get_instance();
			$uri = $CI->lang->localized($uri);			
		}
		$exploded = explode('/', $uri);
		if (in_array($exploded[0], array('admin','members')))
		{
			$suffix_needed=true;
		}
		$uri = parent::site_url($uri);
		if($suffix_needed){
			$suffix = ($this->item('url_suffix') == FALSE) ? '' : $this->item('url_suffix');
			$uri=str_replace($suffix,'',$uri);
		}
		return $uri;
	}
	
}

/* End of file */
