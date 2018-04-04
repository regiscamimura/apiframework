<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('message'))
{
	function message() {
	
		$CI =& get_instance();
		$message = array('message' => $_SESSION['message'], 'warning' => $_SESSION['warning'], 'error' =>$_SESSION['error'], 'success'=> $_SESSION['success']);
		
		$html = '';
		foreach ($message as $type=>$content) {
			if ($content) $html .= "<div class='$type'>$content</div>\n";
			unset($_SESSION[$type]);
		}
		return $html;
	}	
}
if ( ! function_exists('label'))
{
	function label($label) {		
		for ($i=0; $i<strlen($label); $i++) {
			if (ctype_upper($label[$i])) $label = substr_replace($label, "_".strtolower($label[$i]), $i, 1);
		}
			
		return $label = ucwords(str_replace("_", " ", $label));
	}	
}