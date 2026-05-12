<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Cek login
		cek_session();
		$this->load->model("m_default");
	}

	public function index()
	{
		$this->template->load('template', 'front/dashboard');
	}
}
