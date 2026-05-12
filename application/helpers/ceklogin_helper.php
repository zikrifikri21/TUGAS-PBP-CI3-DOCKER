<?php 

function cek_session(){

	$CI =& get_instance();

	$status = $CI->session->userdata('cek_login');
	
	

	if ($status != 'oke')
	{
		redirect('C_auth','refresh');
	}
	else {
		
	}
}
