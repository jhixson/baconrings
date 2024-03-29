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
    $this->data['title'] = 'Contact Us';
    
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
  public function flag()
  {
    $this->data['title'] = 'Flag a Rating';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/flag', $this->data);
    $this->load->view('templates/footer', $this->data);
  }

public function flagthanks()
  {
    $this->data['title'] = 'Thank You for Improving the Ratings';

    //validate form input
    $this->form_validation->set_rules('comments', 'comments', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

         $comments = $this->input->post('comments');
      
         // email functionality here
        $to = "peruta@peruta.com";
        $subject = "RateMyCampus flag form";
        $emailmessage = "Comments: " . $comments . "\n";
        $emailmessage .= "Rating: "  . "(need it here)" . "\n";
        $from = "flagged@ratemycampus.com";
        $headers = "From:" . "flagged@ratemycampus.com";
        mail($to,$subject,$emailmessage,$headers);

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/flagthanks', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
    else
    {
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

      $this->data['comments'] = array('comments' => 'comments',
        'id' => 'comments',
        'type' => 'text',
        'value' => $this->input->post('comments')
      );

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/flag', $this->data);
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
  public function rate($slug='')
  {
  	$this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $slug));
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->data['item']->university_id));
  	$this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
  	$this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => $this->data['item']->category_id));


  	if($this->data['item'])
  	  $this->data['title'] = 'Rate '.$this->data['item']->item_name;
  	
    else
    	show_404();
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/rate', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function ratethanks($slug='')
  {
    $this->data['title'] = 'Rating Submitted';
  	$this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $slug));
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->data['item']->university_id));

    //validate form input
    $this->form_validation->set_rules('att', 'attributes', 'required');
    $this->form_validation->set_rules('comments', 'comments', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true && $this->data['item'])
    {
        $att_arr = $this->input->post('att');
        $comments = $this->input->post('comments');

        $this->forms_model->save_rating($this->data['item'], $att_arr, $comments);

        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/ratethanks', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
    else
    {
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

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
