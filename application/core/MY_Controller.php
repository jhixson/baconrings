<?php

class MY_Controller extends CI_Controller {
  
  function __construct()
	{
	  parent::__construct();
		$this->load->model('campus_model');
		$this->data['campuses'] = $this->campus_model->get_list('university', array(), null, null, 'university_name');
	}
	
}