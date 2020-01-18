<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
	function convert_lang($data,$alphalocalization) {
		if(array_key_exists($data,$alphalocalization)){
			if($alphalocalization[$data]==''){ return $data; } else { return $alphalocalization[$data]; }
		} else {
			return $data;
		}
	}
	
	
	function convert_html($data){		
		  preg_match_all("/{(.*)}/",$data,$matches,PREG_SET_ORDER);
			foreach ($matches as $val) {
				$matched=explode("=",$val[0]);
				$function=str_replace('{','',$matched[0]);
				$link=str_replace('}','',$matched[1]);
				$replacement = $function($link);				
				$data=str_replace($val[0], $replacement, $data);
			}
			return  $data;
	}