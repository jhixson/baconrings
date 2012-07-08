<?php

class Forms extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');
		$this->load->model('campus_model');
    $this->load->model('forms_model');
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
      
         //insert stuff
         $data = array(
          'correction_name' => $name ,
          'correction_email' => $email ,
          'correction_school' => $school ,
          'correction_comments' => $comments ,
          'correction_date' => date("Y-m-d")
        );

         $this->forms_model->input_stuff('correction',$data);

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


// add item form
  public function additem()
  {
    $this->data['title'] = 'Suggest an Item to Add';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    //pass in list of schools
    $this->data['schools']= $this->campus_model->get_list('university', array(), null, null, 'university_name');

    //pass in list of categories
    $this->data['categories']= $this->campus_model->get_list('category', array(), null, null, 'category_name');    

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/additem', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function additemthanks()
  {
    $this->data['title'] = 'Thank You for Your Suggestion';

    //pass in list of schools
    $this->data['schools']= $this->campus_model->get_list('university', array(), null, null, 'university_name');

    //pass in list of categories
    $this->data['categories']= $this->campus_model->get_list('category', array(), null, null, 'category_name');   

    //validate form input
    $this->form_validation->set_rules('email', 'email address', 'required|valid_email');
    $this->form_validation->set_rules('school', 'school', 'required');
    $this->form_validation->set_rules('item', 'item', 'required');
    $this->form_validation->set_rules('category', 'category', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

         $name = $this->input->post('name');
         $email = $this->input->post('email');
         $school = $this->input->post('school');
         $item = $this->input->post('item');
         $category = $this->input->post('category');
         $address = $this->input->post('address');
         $phone = $this->input->post('phone');
         $description = $this->input->post('description');

      
         // email functionality here
        $to = "peruta@peruta.com";
        $subject = "RateMyCampus add item form";
        $emailmessage = "Name: " . $name . "\n";
        $emailmessage .= "Email: "  . $email . "\n";
        $emailmessage .= "School: " . $school . "\n";
        $emailmessage .= "Item: " . $item . "\n";
        $emailmessage .= "Category: " . $category . "\n";
        $emailmessage .= "Address: " . $address . "\n";
        $emailmessage .= "Phone: " . $phone . "\n";
        $emailmessage .= "Description: " . $description . "\n";

        $from = $email;
        $headers = "From:" . $email;
        mail($to,$subject,$emailmessage,$headers);

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/additemthanks', $this->data);
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
      $this->data['item'] = array('name' => 'item',
        'id' => 'item',
        'type' => 'text',
        'value' => $this->form_validation->set_value('item'),
      );
      $this->data['category'] = array('name' => 'category',
        'id' => 'category',
        'type' => 'text',
        'value' => $this->form_validation->set_value('category'),
      );
      $this->data['address'] = array('name' => 'address',
        'id' => 'address',
        'type' => 'text',
        'value' => $this->input->post('address')
      );
      $this->data['phone'] = array('name' => 'phone',
        'id' => 'phone',
        'type' => 'text',
        'value' => $this->input->post('phone')
      );
      $this->data['description'] = array('name' => 'description',
        'id' => 'description',
        'type' => 'text',
        'value' => $this->input->post('description')
      );

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/additem', $this->data);
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


// rate form
  public function rate()
  {
    $this->data['title'] = 'Rate It';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/rate', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function ratethanks()
  {
    $this->data['title'] = 'Rating Submitted';

    //validate form input
    $this->form_validation->set_rules('att1', 'first attribute', 'required');
    $this->form_validation->set_rules('att2', 'second attribute', 'required');
    $this->form_validation->set_rules('att3', 'third attribute', 'required');
    $this->form_validation->set_rules('comments', 'comments', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

         $name = $this->input->post('name');
         $att1 = $this->input->post('att1');
         $att2 = $this->input->post('att2');
         $att3 = $this->input->post('att3');
         $comments = $this->input->post('comments');

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/ratethanks', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
    else
    {
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

      $this->data['att1'] = array('name' => 'att1',
        'id' => 'att1',
        'type' => 'radio',
        'value' => $this->form_validation->set_value('att1'),
      );
      $this->data['att2'] = array('name' => 'att2',
        'id' => 'att2',
        'type' => 'radio',
        'value' => $this->form_validation->set_value('att2'),
      );
      $this->data['att3'] = array('name' => 'att3',
        'id' => 'att3',
        'type' => 'radio',
        'value' => $this->form_validation->set_value('att3'),
      );
      $this->data['comments'] = array('name' => 'comments',
        'id' => 'comments',
        'type' => 'text',
        'value' => $this->form_validation->set_value('comments'),
      );

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/rate', $this->data);
       $this->load->view('templates/footer', $this->data);

    }  

  }

}