<?php  
  
class Explorer extends CI_Controller  
{  
	function index() {		
		
		$data['provider'] = str_replace(array("http://", "https://"), "", base_url());
		
		$this->load->view('explorer/header');
		$this->load->view('explorer/content', $data);
		$this->load->view('explorer/footer');
	}
	
	function view() {
		
		$url = $this->input->post('url');
		$format = $this->input->post('format');
		
		$method = $this->input->post('method');
		$provider = str_replace(array("http://", "https://"), "", base_url());
		$protocol = $this->input->post('protocol');
		
		$server = $protocol."://".$provider."/".
		
		$this->rest->initialize(array(
			'server' => $server,
			'http_user' => 'admin', 
			'http_pass' => '1234',
			'http_auth' => 'digest',
		));
		$this->rest->api_key($this->auth->key());
		
		$parameters = array();
		if ( $this->input->post('param')) $parameters = $this->input->post('param');
		
		$result = $this->rest->$method($url, $parameters, $format); 

		if ($format == 'json') echo json_encode($result);
		else echo "<code>".str_replace(array("<", ">"), array("&lt;", "&gt;"), $this->rest->response_string)."</code>";
		
		if ($this->input->post('debug')) {
			echo $this->rest->debug();
		}
	}
}