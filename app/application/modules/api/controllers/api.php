<?php  
require(APPPATH.'/libraries/REST_Controller.php');  
  
class Api extends REST_Controller  
{  
	function venue_get()  
    {
		if(!$this->get('lat') || !$this->get('lng'))  
        {  
            $this->response('bad request. Please provide lat and lng parameters', 400);  
        }  
  
		$this->load->model('venue_model');
		
		$params = array(
			'lat'		=> $this->get('lat'),
			'lng'		=> $this->get('lng'),
			'radius' 	=> $this->get('radius'),
			'category'	=> $this->get('category'),
			'tag'		=> $this->get('tag'),
			'limit'		=> $this->get('limit'),
			'page'		=> $this->get('page'),
		);
				
        $venue = $this->venue_model->get($params);  
		  
        $this->response($venue, 200); // 200 being the HTTP response code  
    }	
	
	function user_get()  
    {
		if(!$this->get('id'))  
        {  
            $this->response(NULL, 400);  
        }  
  
		$this->load->model('user_model');
        $user = $this->user_model->get( $this->get('id') );  
		  
        if($user)  
        {  
            $this->response($user, 200); // 200 being the HTTP response code  
        }  
  
        else  
        {  
            $this->response(NULL, 404);  
        }  
    }  
  
    function user_post()  
    {  
        $result = $this->user_model->update( $this->post('id'), array(  
            'name' => $this->post('name'),  
            'email' => $this->post('email')  
        ));  
  
        if($result === FALSE)  
        {  
            $this->response(array('status' => 'failed'));  
        }  
  
        else  
        {  
            $this->response(array('status' => 'success'));  
        }  
  
    }  
  
    function users_get()  
    {  
        $this->load->model('user_model');
		$users = $this->user_model->get_all();  
  
        if($users)  
        {  
            $this->response($users, 200);  
        }  
  
        else  
        {  
            $this->response(NULL, 404);  
        }  
    }
}