<?php

class Pages extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
		$this->load->model('campus_model');
		$this->load->library('ion_auth');
	}

	public function view($page = 'home')
	{
	  if ( ! file_exists('application/views/pages/'.$page.'.php'))
    {
  		// Whoops, we don't have a page for that!
  		show_404();
  	}

  	$this->data['title'] = ucfirst($page); // Capitalize the first letter
	
	if($this->ion_auth->logged_in()){
		$this->data['logged_in'] = true;
	}else{
		$this->data['logged_in'] = false;
	}
	

  	$this->load->view('templates/header', $this->data);
  	$this->load->view('pages/'.$page, $this->data);
  	$this->load->view('templates/footer', $this->data);
	}


}