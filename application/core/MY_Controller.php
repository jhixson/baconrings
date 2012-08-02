<?php

class MY_Controller extends CI_Controller {
  
  function __construct()
	{
	  parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('campus_model');
		$this->data['campuses'] = $this->campus_model->get_list('university', array(), null, null, 'university_name');
    $this->data['logged_in'] = $this->ion_auth->logged_in();
	}
	
}
