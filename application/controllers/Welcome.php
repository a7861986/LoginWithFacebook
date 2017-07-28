<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('Facebook');
		//include_once APPPATH . "libraries/Facebook/Facebook.php";
	
	}

	public function index()
	{
		$fbuser = $this->facebook->getUser();
		if ($fbuser) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $fbuser = null;
            }
        }else {
            
        }
		if ($fbuser) {
			$data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => 'http://localhost/ci/welcome/fblogin', 
                'scope' => array("email") // permissions here
            ));
		} else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' =>'http://localhost/ci/welcome/fblogin', 
                'scope' => array("email") // permissions here
            ));
        }
		$this->load->view('welcome_message',$data);
	}

	public function fblogin(){
		$fb_user = $this->facebook->getUser(); 

		$facebook = new Facebook(array(
		'appId' => $this->config->item('appId'),
		'secret' => $this->config->item('secret'),
		));
		
		$profile = NULL;
		$logout = NULL;

		//print_r($fb_user);die;
		if ($fb_user) {
			  try {
				// Proceed knowing you have a logged in user who's authenticated.
				$profile = $facebook->api('/me?fields=email,first_name,last_name');
			  } catch (FacebookApiException $e) {
				error_log($e);
				$fb_user = null;
			  }
		}else{
			redirect('login/');
		}

		print_r($profile);die;
	}
}
