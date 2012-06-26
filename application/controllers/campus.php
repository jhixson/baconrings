<?php

class Campus extends CI_Controller {
  
  function __construct()
	{
		parent::__construct();
		$this->load->model('campus_model');
	}

	public function find()
	{
  	$data['title'] = 'Find Your Campus'; // Capitalize the first letter
  	
  	$data['campuses'] = $this->campus_model->get_campuses('university', array());

  	$this->load->view('templates/header', $data);
  	$this->load->view('campus/find', $data);
  	$this->load->view('templates/footer', $data);
	}
}