<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accessdenied extends Web_Controller {
	public function index()
	{
		$main['page_title']='Access Denied';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();		
		$main['content']=$this->load->view('admin/content/accessdenied','',true);
		$this->load->view('admin/main',$main);
		
	}
	
}
/* End of file contents.php */
/* Location: ./application/controllers/contents.php */