<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Web_Controller extends CI_Controller {
    function __construct()
    {
        parent::__construct();
		$this->load->model('language_model');		
		$this->huntid = $this->session->userdata('sesshuntid');
        $this->load->model('settings_model');
		$settings=$this->settings_model->get_array();
		foreach($settings as $setting):
			$this->alphasettings[$setting['settingkey']]=$setting['settingvalue'];
		endforeach;
		$this->languagesarr = $this->language_model->get_active_array();
		$this->langcodes=$this->language_model->language_conversion();
        $this->jsString= '';
        $this->jsArray = array();
        $this->cssArray = array(); 
		if($this->session->userdata('sesshuntid') == 0){ $redirect = 'login'; } else {$redirect = 'signin'; }
		if(!$this->session->userdata('admin_logged_in'))
		{
		   redirect('admin/'.$redirect);		
		}
		/*if($this->session->userdata('admin_role')!='1'){
			$this->checkpermissions(); 
		}*/ 
    }
	
	function adminheader()
	{
		$this->load->model('login_model');
		$this->load->model('adminmenu_model');	
		$this->load->model('menu_model');	
		$header['login']=$this->login_model->get_lastlogin();
		$header['menus']=$this->adminmenu_model->get_menu();
		$header['frontmenus']=$this->menu_model->get_array();
		//$header['langs']=$this->language_model->get_active();
		return  $this->load->view('admin/include/header',$header,true);
	}
	function adminfooter()
	{
		$footer['menus']='';
		return $this->load->view('admin/include/footer',$footer,true);
		
	}
	function adminleftmenu()
	{
		$this->load->model('adminmenu_model');	
		$this->load->model('menu_model');	
		$left['menus']=$this->adminmenu_model->get_menu();
		$left['frontmenus']=$this->menu_model->get_array();
		return $this->load->view('admin/include/left',$left,true);
	}
	
	function sendfromadmin($to,$subject,$message)
	{
	
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;		
		$this->email->initialize($config);
		
		$this->email->from($this->alphasettings['FROM_EMAIL'], 'Web Admin');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);		
		if($this->email->send()){ return true; } else { return false; }
	}
	
	function get_featurecategory_tree($id='0',$selected='')
	{
		$this->load->model('featurecategory_model');
		return $this->featurecategory_model->get_category_tree($id,$selected);
	}
	
	function get_menu_tree($menuid='',$id='0',$selected='')
	{
		$this->load->model('menuitems_model');
		return $this->menuitems_model->get_category_tree($menuid,$id,$selected);
	}
	
	function render_menuitems_lists($menucond,$selected='')
	{
		$this->load->model('menuitems_model');
		return $this->menuitems_model->get_menu_list_tree($menucond,$selected);
	}
	public function clear_all_cache()
        {
        $CI =& get_instance();
	$path = $CI->config->item('cache_path');
        
        $cache_path = ($path == '') ? APPPATH.'cache/' : $path;
        
        $handle = opendir($cache_path);

        while (($file = readdir($handle))!== FALSE) 
        {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html')
            {
               @unlink($cache_path.'/'.$file);
            }
        }
        closedir($handle);
        }
	function checkpermissions(){	
		$this->load->model('admin_model');
		$link=$this->uri->segment(1);
		if($this->uri->segment(2))
		$link.='/'.$this->uri->segment(2);
		if($this->uri->segment(3))
		$link.='/'.$this->uri->segment(3);
		if(($link=='admin') || ($link=='admin/home') || ($link=='admin/home/logout') || ($link=='admin/accessdenied')){			
			//redirect($link);	
		}else{   
			$cond=array('url'=>$link);		
			$permission=$this->admin_model->check_permission($cond);		
			if($permission)
			{
				$acc_cond=array('permissions_id'=>$permission->permissions_id,'roles_id'=>$this->session->userdata('admin_role')); 
				$access=$this->admin_model->check_access($acc_cond);	
				if($access==0){
					redirect('admin/accessdenied');
				}
			}
		}
	}function dob_check($str){ 		
		if(!checkdate($this->input->post('month'), $this->input->post('day'), $this->input->post('year'))){
			 $this->form_validation->set_message('dob_check', convert_lang('invalid date'));
		     return false;    	 		 
		}else{		 
		    return true; 
		}
	}
	function mobile_check($str){ 		
		if(!preg_match('/^\+?[0-9]+$/', trim(str_replace(' ','',$str)))){
			 $this->form_validation->set_message('mobile_check', convert_lang('invalid number'));
		     return false;    	 		 
		}else{		 
		    return true; 
		}
	}
}
/* Frontend Controller*/
class Webfront_Controller extends CI_Controller {
    function __construct()
    {
        parent::__construct();
		$this->load->model('language_model');	
		$this->load->model('frontend/qas_model');		
		$this->load->helper('text');
		$this->load->library('user_agent');
		$this->languagesarr = $this->language_model->get_active_array();
		$this->langcodes=$this->language_model->language_conversion();
		if($this->config->item('language')!=''){
			$newdata=array('front_language'=>$this->langcodes[$this->config->item('language')]);
		}
		$this->session->set_userdata($newdata);
		$this->alphasettings=array();
        $this->jsString=$this->signedduser= $this->tasks='';
        $this->jsArray = array();
		$this->alphalocalization=array();
 		$this->mobileversion = $this->agent->is_mobile();	
		$this->fronthead();	
		if($this->session->userdata('sessid') !=''){
			$this->load->model('users_model');	
			$this->signedduser = $this->users_model->load($this->session->userdata('sessid'));
			//$this->taskrecover = $this->qas_model->recover_task(); 
			$qas=$this->qas_model->get_active();
			$tasks = array();
			if($qas) foreach($qas as $key => $qus):
			$tasks[$qus['id']] = $key+1;  
			endforeach;
			$this->tasks = $tasks; 
		} 
		$this->clear_all_cache();	  
		$this->huntid = 1;//$this->session->userdata('sesshuntid');
    }
	public function clear_all_cache()
    {
		
        $CI =& get_instance();
		$path = $CI->config->item('cache_path'); 
        $cache_path = ($path == '') ? APPPATH.'cache/' : $path; 
        $handle = opendir($cache_path); 
        while (($file = readdir($handle))!== FALSE) 
        { 
            if ($file != '.htaccess' && $file != 'index.html')
            {
               @unlink($cache_path.'/'.$file); 
            }
        } 
        closedir($handle);
    }
	function get_featurecategory_tree($id='0',$selected='')
	{
		$this->load->model('featurecategory_model');
		return $this->featurecategory_model->get_category_tree($id,$selected);
	}
	
	function get_menu_tree($menuid='',$id='0',$selected='')
	{
		$this->load->model('menuitems_model');
		return $this->menuitems_model->get_category_tree($menuid,$id,$selected);
	}
	
	function render_menuitems_lists($menucond,$selected='')
	{
		$this->load->model('menuitems_model');
		return $this->menuitems_model->get_menu_list_tree($menucond,$selected);
	}
	function fronthead()
	{
		//$this->load->model('menuitems_model'); 
		$this->huntid = $this->session->userdata('sesshuntid');
		$this->load->model('settings_model');
		$this->load->model('localization_model');
		//$this->load->model('contents_model'); 
		//$this->load->model('contentcategory_model'); 
		$settings=$this->settings_model->get_array();	
		foreach($settings as $setting):
			$this->alphasettings[$setting['settingkey']]=$setting['settingvalue'];
		endforeach;
		$localizations=$this->localization_model->get_array();
		foreach($localizations as $localization):
			$this->alphalocalization[$localization['lang_key']]=$localization['lang_value'];
		endforeach;
		/*$contents=$this->contents_model->get_array();
		foreach($contents as $content):
			$this->contentslugs[$content['id']]=$content['slug'];
		endforeach;
		$catcontents=$this->contentcategory_model->get_array();
		foreach($catcontents as $catcontent):
			$this->contentcategoryslugs[$catcontent['id']]=$catcontent['slug'];
		endforeach; */ 
		$this->pagetitle=$this->alphasettings['DEFAULT_META_TITLE']; 
		$this->desc=$this->alphasettings['DEFAULT_META_DESCRIPTION']; 
		$this->keys=$this->alphasettings['DEFAULT_META_KEYWORDS'];
		$this->phone=$this->alphasettings['PHONE'];		
		$this->pagebannnertext='';
		$this->breadcrumbarr=array();
		$this->currentmenu='';
		$this->currentparentmenu='';
	}
	function mailheader()
	{
		$this->load->model('hunts_model'); 
		$header['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid'));
		return  $this->load->view('frontend/mail/mailheader',$header,true);		
	}
	function mailfooter()
	{
		return  $this->load->view('frontend/mail/mailfooter','',true);		
	}
	function frontmetahead()
	{
		return  $this->load->view('frontend/include/meta','',true);		
	}
	
	function frontheader()
	{ 
		$oat = $this->alphasettings['HUNT_TIME'];
		$header['hunttime'] =$oat[0]*3600+$oat[1]*60+$oat[2];
		return  $this->load->view('frontend/include/header',$header,true);
	}
	
	function frontcontent($frontcontents)
	{  
		$frontcontent['maintcontent']=$frontcontents;   
		return $this->load->view('frontend/include/content',$frontcontent,true);
	}
	
	
	function frontprintcontent($frontcontents)
	{ 
		$frontcontent['maintcontent']=$frontcontents; 
		return $this->load->view('frontend/include/printcontent',$frontcontent,true);
	}
	  
	function frontfooter()
	{
 		$footer['footermenus']= '';//$this->menuitems_model->get_menu_footer('footer');   
		return $this->load->view('frontend/include/footer',$footer,true);	
	}
	
	function alphaspace_check($str){ 		
			if(!preg_match('/^([a-z ]|\p{Arabic})+$/iu', trim($str))){
			 $this->form_validation->set_message('alphaspace_check', convert_lang('alphabets only',$this->alphalocalization));
		     return false;    	 		 
		}else{		 
		    return true; 
		}
	}
	
	function captcha_check($str){ 
			$expiration = time()-7200; // Two hour limit
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			
			// Then see if a captcha exists:
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($str, $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();			
			if ($row->count == 0)
			{
			 $this->form_validation->set_message('captcha_check', convert_lang('invalid security code',$this->alphalocalization));
		     return false;    	 		 
			}else{		 
				return true; 
			}
	}
		
	function sendfromadmin($to,$subject,$message,$attachment='')
	{
		/*$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;		*/
		$this->load->library('email');
		$config['protocol'] = 'smtp'; // mail, sendmail, or smtp    The mail sending protocol.
		$config['smtp_host'] = 'mail.webchannel.co'; // SMTP Server Address.
		$config['smtp_user'] = 'smtp@webchannel.ae'; // SMTP Username.
		$config['smtp_pass'] = 'NEWp@AssW6d!@#'; // SMTP Password.
		$config['smtp_port'] = '25'; // SMTP Port.
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;	
		$this->email->initialize($config);
		$this->email->from($this->alphasettings['FROM_EMAIL'], 'Web Admin - GymsInTown.com');
		$this->email->to($to);		
		$this->email->subject($subject);
		$this->email->message($message);
		if($attachment!=''){$this->email->attach($attachment);	}
		if($this->email->send()){ return true; } else { return false; }
	}
	function sendtoadmin($fromemail,$fromname,$attachment,$subject,$message)
	{
		$this->load->library('email');
		$config['protocol'] = 'smtp'; // mail, sendmail, or smtp    The mail sending protocol.
		$config['smtp_host'] = 'mail.webchannel.co'; // SMTP Server Address.
		$config['smtp_user'] = 'smtp@webchannel.ae'; // SMTP Username.
		$config['smtp_pass'] = 'NEWp@AssW6d!@#'; // SMTP Password.
		$config['smtp_port'] = '25'; // SMTP Port.
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;	
		$this->email->initialize($config);
		
		$this->email->from($fromemail, $fromname); 
		$this->email->to($this->alphasettings['ADMIN_EMAIL']);
		$this->email->subject($subject);
		$this->email->message($message);		
		$this->email->attach($attachment);	
		if($this->email->send()){ return true; } else { return false; }
	}
	
	function sendtoadminmutiple($fromemail,$fromname,$attachment1,$attachment2,$subject,$message)
	{
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;		
		$this->email->initialize($config);
		
		$this->email->from($fromemail, $fromname); 
		$this->email->to($this->alphasettings['ADMIN_EMAIL']);
		$this->email->subject($subject);
		$this->email->message($message);		
		$this->email->attach($attachment1);	
		$this->email->attach($attachment2);	
	
		if($this->email->send()){ return true; } else { return false; }
	}
	function adminnotification($subject,$message)
	{
		/*$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;	*/	
		$this->load->library('email');
		$config['protocol'] = 'smtp'; // mail, sendmail, or smtp    The mail sending protocol.
		$config['smtp_host'] = 'mail.webchannel.co'; // SMTP Server Address.
		$config['smtp_user'] = 'smtp@webchannel.ae'; // SMTP Username.
		$config['smtp_pass'] = 'NEWp@AssW6d!@#'; // SMTP Password.
		$config['smtp_port'] = '25'; // SMTP Port.
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;	
		$this->email->initialize($config); 
		$this->email->from($this->alphasettings['FROM_EMAIL'],'Web Admin - GymsInTown.com');
		$this->email->to($this->alphasettings['ADMIN_EMAIL']);
		$this->email->subject($subject);
		$this->email->message($message);
	
		if($this->email->send()){ return true; } else { return false; }
	}
	
	function sendtofriend($fromemail,$fromname,$toemail,$toname,$subject,$message)
	{
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;		
		$this->email->initialize($config);
		
		$this->email->from($fromemail,$fromname);
		$this->email->to($toemail,$toname);
		$this->email->subject($subject);
		$this->email->message($message);		
		if($this->email->send()){ return true; } else { return false; }
	}
	
	function outputCache(){
		if($this->alphasettings['CACHE_TIME']!='0'){
			$this->output->cache($this->alphasettings['CACHE_TIME']);
		}
	}
	function dob_check($str){ 		
		if(!checkdate($this->input->post('month'), $this->input->post('day'), $this->input->post('year'))){
			 $this->form_validation->set_message('dob_check', convert_lang('invalid date'));
		     return false;    	 		 
		}else{		 
		    return true; 
		}
	}
	function mobile_check($str){ 		
		if(!preg_match('/^\+?[0-9]+$/', trim(str_replace(' ','',$str)))){
			 $this->form_validation->set_message('mobile_check', convert_lang('invalid number'));
		     return false;    	 		 
		}else{		 
		    return true; 
		}
	}
	function getLocationInfoByIp()
	{
	
	  $client_ip  = @$_SERVER['HTTPS_CLIENT_IP'];
	  $forward_ip = @$_SERVER['HTTPS_X_FORWARDED_FOR'];
	  $remote_ip  = @$_SERVER['REMOTE_ADDR'];
	 /*
	 $client_ip  = '83.110.193.87';
	 $forward_ip = '83.110.193.87';
	 $remote_ip  = '83.110.193.87';
	 */
	 $return_data  = array('country'=>'UAE', 'city'=>'Dubai');//Sharjah
	 if(filter_var($client_ip, FILTER_VALIDATE_IP))
	 {
	  $ip_addr = $client_ip;
	 }
	 elseif(filter_var($forward_ip, FILTER_VALIDATE_IP))
	 {
	  $ip_addr = $forward_ip;
	 }
	 else
	 {
	  $ip_addr = $remote_ip;
	 }
	 $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip_addr));
	// print_r($ip_data);
	 if($ip_data && $ip_data->geoplugin_countryName != null)
	 {
	  $return_data['country'] = $ip_data->geoplugin_countryCode;
	  $return_data['city'] = $ip_data->geoplugin_city;
	 }
	 return $return_data;
	}
}