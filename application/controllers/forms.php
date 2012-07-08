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


// contact form
  public function contact()
  {
    $this->data['title'] = 'Sumbit Correction';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/contact', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function contactthanks()
  {
    $this->data['title'] = 'Contact Us Thank You';

    //validate form input
    $this->form_validation->set_rules('email', 'email address', 'required|valid_email');
    $this->form_validation->set_rules('comments', 'comments/correction', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

         $name = $this->input->post('name');
         $email = $this->input->post('email');
         $school = $this->input->post('school');
         $comments = $this->input->post('comments');
      
         // email functionality here
        $to = "peruta@peruta.com";
        $subject = "RateMyCampus contact us form";
        $emailmessage = "Name: " . $name . "\n";
        $emailmessage .= "Email: "  . $email . "\n";
        $emailmessage .= "School: " . $school . "\n";
        $emailmessage .= "Comments: " . $comments . "\n";
        $from = $email;
        $headers = "From:" . $email;
        mail($to,$subject,$emailmessage,$headers);

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/contactthanks', $this->data);
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
       $this->load->view('forms/contact', $this->data);
       $this->load->view('templates/footer', $this->data);

    }  

  }


// add category form
  public function addcategory()
  {
    $this->data['title'] = 'Suggest a Category to Add';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/addcategory', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function addcategorythanks()
  {
    $this->data['title'] = 'Thank You for Your Suggestion';

    //validate form input
    $this->form_validation->set_rules('email', 'email address', 'required|valid_email');
    $this->form_validation->set_rules('category', 'category', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

         $name = $this->input->post('name');
         $email = $this->input->post('email');
         $school = $this->input->post('school');
         $category = $this->input->post('category');
      
         // email functionality here
        $to = "peruta@peruta.com";
        $subject = "RateMyCampus add category form";
        $emailmessage = "Name: " . $name . "\n";
        $emailmessage .= "Email: "  . $email . "\n";
        $emailmessage .= "School: " . $school . "\n";
        $emailmessage .= "Category: " . $category . "\n";
        $from = $email;
        $headers = "From:" . $email;
        mail($to,$subject,$emailmessage,$headers);

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/addcategorythanks', $this->data);
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
      $this->data['category'] = array('name' => 'category',
        'id' => 'category',
        'type' => 'text',
        'value' => $this->form_validation->set_value('category'),
      );

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/addcategory', $this->data);
       $this->load->view('templates/footer', $this->data);

    }  

  }




// forgot password form
  public function forgotpassword()
  {
    $this->data['title'] = 'Forgot Password';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/forgotpassword', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function forgotpasswordthanks()
  {
    $this->data['title'] = 'Forgot Password Thank You';

    //validate form input
    $this->form_validation->set_rules('email', 'email address', 'required|valid_email');
    
    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {
         $email = $this->input->post('email');
      
        // email functionality here
        //$to = "peruta@peruta.com";
        //$subject = "RateMyCampus contact us form";
        //$emailmessage = "Name: " . $name . "\n";
        //$emailmessage .= "Email: "  . $email . "\n";
        //$emailmessage .= "School: " . $school . "\n";
        //$emailmessage .= "Comments: " . $comments . "\n";
        //$from = $email;
        //$headers = "From:" . $email;
        //mail($to,$subject,$emailmessage,$headers);

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/forgotpasswordthanks', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
    else
    {
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

      $this->data['email'] = array('name' => 'email',
        'id' => 'email',
        'type' => 'text',
        'value' => $this->form_validation->set_value('email'),
      );
      
       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/forgotpassword', $this->data);
       $this->load->view('templates/footer', $this->data);

    }  

  }

}