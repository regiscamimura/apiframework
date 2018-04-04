<?php 

class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_all()
    {
        $query = $this->db->get('user', 10);
        return $query->result_array();
    }
	
	function get($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('user');
		
		return $row = $query->row_array();
	}
}
