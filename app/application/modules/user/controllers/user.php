<?php  
  
class User extends CI_Controller  
{  
	function __construct() {
		parent::__construct();
		//force_ssl();
	}
	function index() {		
		
	}
	
	function login() {
		
		if ($rec = $this->input->post('rec')) {
			if ($this->auth->login($rec['username'], $rec['password'])) {
				redirect('/');
			}
			else {
				$_SESSION['warning'] = 'Invalid username or password';
			}
		}
		
		$this->load->view('header');
		$this->load->view('user/login');
		$this->load->view('footer');
	}
	
	function logout() {
		unset($_SESSION['user_id']);
		redirect('/');
	}
}