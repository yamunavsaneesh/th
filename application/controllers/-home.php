<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Webfront_Controller {
	public function index($gcc='ae')
	{
		$this->outputCache();
		$this->load->model('frontend/banners_model');
		$this->load->model('frontend/contacts_model');
		$this->load->model('frontend/settings_model');
		$main['meta']=$this->frontmetahead();
		$home['works']=$this->contents_model->get_catcontents('how-it-works');
		$home['choosepass']=$this->contents_model->get_row_cond(array('slug'=>$this->alphasettings['CHOOSE_PASS']));
		$home['whygyms']=$this->contents_model->get_row_cond(array('slug'=>$this->alphasettings['WHY_GYMS'])); 
		
		//$home['gymslist'] = $this->contents_model->getAllGyms();
		//$home['pagelists']=$this->news_model->get_catnews('news');
		$main['gcc']=$gcc;
		if($gcc=='ae'){
			$frontcontent=$this->load->view('frontend/content/home',$home,true);
			$main['contents']=$this->frontcontent($frontcontent,false);
		}else {
			$frontcontent=$this->load->view('frontend/content/comingsoon',$home,true);
			$main['contents']=$this->frontcontent($frontcontent,true);
		}
		$main['header']=$this->frontheader();
		$main['footer']=$this->frontfooter(true);
		$this->load->view('frontend/main',$main);
	} 
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */