<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$this->load->view('welcome_message');
	}
	public function closeOutput($stringToOutput){   
        set_time_limit(0);
        ignore_user_abort(true);
        header("Connection: close\r\n");
        header("Content-Encoding: none\r\n");  
        ob_start();          
        echo $stringToOutput;   
        $size = ob_get_length();   
        header("Content-Length: $size",TRUE);  
        ob_end_flush();
        ob_flush();
        flush();   
} 
		public function test(){
 ob_end_clean();
 header("Connection: close");
 ignore_user_abort(); // optional
 ob_start();
 echo ('Text the user will see');
 $size = ob_get_length();
 header("Content-Length: $size");
 ob_end_flush(); // Strange behaviour, will not work
 flush();            // Unless both are called !
 // Do processing here 
 sleep(30);
 echo('Text user will never see');
 
		//$this->load->view('welcome_message');
	}
}
