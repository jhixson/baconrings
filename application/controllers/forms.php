<?php

class Forms extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');
		$this->load->model('campus_model');
	}

  
  // submit correction form
  public function submitcorrection()
  {
    $this->data['title'] = 'Sumbit Correction';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/submitcorrection', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function submitcorrectionthanks()
  {
    $this->data['title'] = 'Sumbit Correction Thank You';

    //validate form input
    $this->form_validation->set_rules('email', 'email address', 'required|valid_email');
    $this->form_validation->set_rules('comments', 'comments/correction', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

      //if($this->input->post('email'))
         $name = $this->input->post('name');
         $email = $this->input->post('email');
         $school = $this->input->post('school');
         $comments = $this->input->post('comments');
      
         // email functionality here
        $to = "peruta@peruta.com";
        $subject = "RateMyCampus correction form";
        $emailmessage = "Name: " . $name . "\n";
        $emailmessage .= "Email: "  . $email . "\n";
        $emailmessage .= "School: " . $school . "\n";
        $emailmessage .= "Comments: " . $comments . "\n";
        $from = $email;
        $headers = "From:" . $email;
        mail($to,$subject,$emailmessage,$headers);

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/submitcorrectionthanks', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
    else
    {
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

      $this->data['name'] = array('name' => 'name',
        'id' => 'name',
        'type' => 'text',
        'value' => $this->input->post('name')
      );
      $this->data['email'] = array('name' => 'email',
        'id' => 'email',
        'type' => 'text',
        'value' => $this->form_validation->set_value('email'),
      );
      $this->data['school'] = array('name' => 'school',
        'id' => 'school',
        'type' => 'text',
        'value' => $this->input->post('school')
      );
      $this->data['comments'] = array('name' => 'comments',
        'id' => 'comments',
        'type' => 'text',
        'value' => $this->form_validation->set_value('comments'),
      );

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/submitcorrection', $this->data);
       $this->load->view('templates/footer', $this->data);

    }  

  }


}