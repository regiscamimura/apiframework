<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

    function __construct()
    {
		$CI =& get_instance();
		
		$currentModule = $CI->uri->segment(1);
		$currentFunction = $CI->uri->segment(2);
		
		if (($currentModule == 'explorer' || $currentModule == '') && $currentModule != 'user' && $currentFunction != 'login' && !$_SESSION['user_id']) {
			redirect('/user/login');
		}	
    }
		
	function login($username, $password) {
		$CI =& get_instance();
		
		$CI->db->where('user.username', $username);
		$CI->db->where("user.password = MD5('$password')");
		
		$query = $CI->db->get('user');
		$result = $query->result_array();
		
		if(empty($result)) return false;
		
		$row = $result[0];
		
		$_SESSION['user_id'] = $row['id'];

		return $row['id'];
	}
	function key() {
		$CI =& get_instance();
		$user_id = $_SESSION['user_id'];
		
		$CI->db->select('keys.key');
		$CI->db->where('user.id', $user_id);
		$CI->db->join('keys', 'keys.id = user.key_id AND keys.id IS NOT NULL');
				
		$query = $CI->db->get('user');
		$result = $query->result_array();
		
		if(empty($result)) return false;
		
		$row = $result[0];
		
		return $row['key'];
	}
	function level() {
		$CI =& get_instance();
		$user_id = $_SESSION['user_id'];
		
		$CI->db->select('keys.level');
		$CI->db->where('user.id', $user_id);
		$CI->db->join('keys', 'keys.id = user.key_id AND keys.id IS NOT NULL');
				
		$query = $CI->db->get('user');
		$result = $query->result_array();
		
		if(empty($result)) return false;
		
		$row = $result[0];
		
		return $row['level'];
	}

}

?>