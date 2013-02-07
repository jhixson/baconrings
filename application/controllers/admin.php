<?php

class Admin extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->library('ion_auth');
		
		$this->load->model('campus_model');
	}

	function index(){

		$this->load->view('admin/header');
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}

}
?>