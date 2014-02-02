<?php

class Forms extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->library('ion_auth');
    
		$this->load->model('campus_model');
    $this->load->model('forms_model');
	}

  
  // submit correction form
  public function submitcorrection($slug='')
  {
    $this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $slug));
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->data['item']->university_id));
  	$this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
  	$this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => $this->data['item']->category_id));
  	
    $this->data['title'] = 'Sumbit Correction';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/submitcorrection', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function submitcorrectionthanks($slug='')
  {
    $this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $slug));
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->data['item']->university_id));
  	$this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
  	
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
         $itemm = $this->input->post('itemm');
         $comments = $this->input->post('comments');
      
         //insert stuff
         $data = array(
          'correction_name' => $name ,
          'correction_email' => $email ,
          'correction_school' => $school ,
          'correction_item' => $itemm ,
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
        $emailmessage .= "Item: " . $itemm . "\n";
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
  public function flag($campus_slug='', $comment_id='', $item_slug='')
  {
    $this->data['comment'] = $this->campus_model->get_single('rating', array('rating_id' => $comment_id));
    $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
    if(!empty($item_slug)) {
      $this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $item_slug));
      $this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
    }
    
    $this->data['title'] = 'Flag a Rating';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/flag', $this->data);
    $this->load->view('templates/footer', $this->data);
  }

  public function flagthanks($campus_slug='', $comment_id='', $item_slug='')
  {
    $this->data['comment'] = $this->campus_model->get_single('rating', array('rating_id' => $comment_id));
    $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
    if(!empty($item_slug)) {
      $this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $item_slug));
      $this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
    }
      
    $this->data['title'] = 'Thank You for Improving the Ratings';

    //validate form input
    $this->form_validation->set_rules('comments', 'comments', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

         $comments = $this->input->post('comments');
      
         // email functionality here
        $this->load->library('email');
        
        $this->email->from('flagged@ratemycampus.com', 'flagged@ratemycampus.com');
        $this->email->to('hixsonj@gmail.com'); 
        $this->email->to('peruta@peruta.com'); 
        
        $this->email->subject('RateMyCampus flag form');
        $emailmessage = "Rating: " . $this->data['comment']->rating_comments . "<br />\n";
        $emailmessage .= "University: " . $this->data['campus']->university_name . "<br />\n";
        if(isset($this->data['item'])) {
          $emailmessage .= "Category: " . $this->data['category']->category_name . "<br />\n";
          $emailmessage .= "Item: " . $this->data['item']->item_name . "<br />\n";
        }
        $emailmessage .= "Comments on rating: " . $comments . "<br />\n";
        $this->email->message($emailmessage);	

        $this->email->send();

        //echo $this->email->print_debugger();

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
  public function addcategory($slug='')
  {
    $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $slug));
  	
    $this->data['title'] = 'Suggest a Category to Add';
    
    //set the flash data error message if there is one
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->view('templates/header', $this->data);
    $this->load->view('forms/addcategory', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


  public function addcategorythanks($slug='')
  {
    $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $slug));
    
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
         $comments = $this->input->post('comments');
      
         // email functionality here
        $to = "peruta@peruta.com";
        $subject = "RateMyCampus add category form";
        $emailmessage = "Name: " . $name . "\n";
        $emailmessage .= "Email: "  . $email . "\n";
        $emailmessage .= "School: " . $school . "\n";
        $emailmessage .= "Category: " . $category . "\n";
        $emailmessage .= "List of Items: " . $comments . "\n";
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
      $this->data['comments'] = array('name' => 'comments',
        'id' => 'comments',
        'type' => 'text',
        'value' => $this->input->post('comments'),
      );

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/addcategory', $this->data);
       $this->load->view('templates/footer', $this->data);

    }  

  }


// add item form
  public function additem($campus_slug='', $category_slug='')
  {
    $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
  	$this->data['category'] = $this->campus_model->get_single('category', array('category_slug' => $category_slug));
    
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


  public function additemthanks($campus_slug='', $category_slug='')
  {
    $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
  	$this->data['category'] = $this->campus_model->get_single('category', array('category_slug' => $category_slug));
  	
    $this->data['title'] = 'Thank You for Your Suggestion';

    //pass in list of schools
    $this->data['schools']= $this->campus_model->get_list('university', array(), null, null, 'university_name');

    //pass in list of categories
    $this->data['categories']= $this->campus_model->get_list('category', array(), null, null, 'category_name');   

    //validate form input
    $this->form_validation->set_rules('email', 'email address', 'required|valid_email');
    $this->form_validation->set_rules('school', 'school', 'required');
    $this->form_validation->set_rules('item', 'item', 'required');
    $this->form_validation->set_rules('cat', 'cat', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true)
    {

         $name = $this->input->post('name');
         $email = $this->input->post('email');
         $school = $this->input->post('school');
         $item = $this->input->post('item');
         $category = $this->input->post('cat');
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
        
        $forgotten = $this->ion_auth->forgotten_password($email);

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
  public function rate($campus_slug='',$item_slug='')
  {
    //if($this->ion_auth->logged_in()) {
      $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
  	  $this->data['item'] = $this->campus_model->get_single('item', array('university_id' => $this->data['campus']->university_id, 'item_slug' => $item_slug));
    	$this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
    	$this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => $this->data['item']->category_id));


    	if($this->data['campus'] && $this->data['item'])
    	  $this->data['title'] = 'Rate '.$this->data['item']->item_name;
  	
      else
      	show_404();
    
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $this->load->view('templates/header', $this->data);
      $this->load->view('forms/rate', $this->data);
      $this->load->view('templates/footer', $this->data);
    /*
    }
    else{
        $this->load->helper('cookie');
        $cookie = array(
          'name'   => 'redirect_url',
          'value'  => current_url(),
          'expire' => '3600'
        );
        set_cookie($cookie);
    		$this->data['title'] = "Login";
			  $this->data['location'] = $this->uri->uri_string();
    		$this->data['message'] = "<li>You must be logged in to rate stuff. Don't worry, we never show your username with any ratings.</li><br /><br />";
    		$this->load->view('templates/header', $this->data);
    		$this->load->view('auth/login', $this->data);
    		$this->load->view('templates/footer', $this->data);
    	}
    */
  }


  public function ratethanks($campus_slug='',$item_slug='')
  {
    $this->data['title'] = 'Rating Submitted';
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
	  $this->data['item'] = $this->campus_model->get_single('item', array('university_id' => $this->data['campus']->university_id, 'item_slug' => $item_slug));
    $this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
    $this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => $this->data['item']->category_id));

    //validate form input
    $this->form_validation->set_rules('att', 'attributes', 'required');
    $this->form_validation->set_rules('comments', 'comments', 'required');
	
	// captcha
	//require_once('/Applications/MAMP/htdocs/baconrings/application/views/forms/recaptchalib.php');
	require_once('/home/peruta/dev.baconrings.com/application/views/forms/recaptchalib.php');
	$privatekey = "6Lc27NgSAAAAAH1q-aJOpzUAESS30J-E5I_WV1Q_";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	$this->data['resp'] = $resp;
	if (!$resp->is_valid) {
	  $this->data['message'] = "<li>Captcha was incorrect.</li>";
	  
	  $this->data['comments'] = array('name' => 'comments',
      'id' => 'comments',
      'type' => 'text',
      'value' => $this->input->post('comments')
    );
    
    $this->data['att'] = $this->input->post('att');

     $this->load->view('templates/header', $this->data);
     $this->load->view('forms/rate', $this->data);
     $this->load->view('templates/footer', $this->data);
   }
   else {

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true && $this->data['item'])
    {
        $att_arr = $this->input->post('att');
        $comments = $this->input->post('comments');

        $this->forms_model->save_rating($this->data['item']->item_id, $att_arr, $comments);

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
        'value' => $this->input->post('comments')
      );
      
      $this->data['att'] = $this->input->post('att');

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/rate', $this->data);
       $this->load->view('templates/footer', $this->data);
    }  
  }
}
  
  public function ratecampus($slug='')
  {
    //if($this->ion_auth->logged_in()) {
  	  $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $slug));
    	$this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => 0));

    	if($this->data['campus'])
    	  $this->data['title'] = 'Rate '.$this->data['campus']->university_name;
  	
      else
      	show_404();
    
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->load->view('templates/header', $this->data);
      $this->load->view('forms/ratecampus', $this->data);
      $this->load->view('templates/footer', $this->data);
    /*
    }
    else {
      //$_SESSION['alert'] = 'You need to be logged in to add ratings. <a href="/login">Click here</a> to log in.';
      //redirect('/'.$slug,'location');
      $this->load->helper('cookie');
      $cookie = array(
          'name'   => 'redirect_url',
          'value'  => current_url(),
          'expire' => '3600'
      );
      set_cookie($cookie);
      $this->data['title'] = "Login";
	    $this->data['location'] = $this->uri->segment(1);
  		$this->data['message'] = "<li>You must be logged in to rate stuff. Don't worry, we never show your username with any ratings.</li><br /><br />";
  		$this->load->view('templates/header', $this->data);
  		$this->load->view('auth/login', $this->data);
  		$this->load->view('templates/footer', $this->data);
    }
    */
  }
  
  public function ratecampusthanks($slug='')
  {
    $this->data['title'] = 'Rating Submitted';
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $slug));
  	$this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => 0));

    //validate form input
    $this->form_validation->set_rules('att', 'attributes', 'required');
    $this->form_validation->set_rules('comments', 'comments', 'required');

    $this->form_validation->set_error_delimiters('<li>','</li>');
	
	// recaptcha
	//include('recaptchalib.php');
	//$this->load->helper('recaptchalib');
	//require_once('/Applications/MAMP/htdocs/baconrings/application/views/forms/recaptchalib.php');
	require_once('/home/peruta/dev.baconrings.com/application/views/forms/recaptchalib.php');
	$privatekey = "6Lc27NgSAAAAAH1q-aJOpzUAESS30J-E5I_WV1Q_";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

	if (!$resp->is_valid) {
	  $this->data['message'] = "<li>Captcha was incorrect.</li>";

		$this->data['comments'] = array('name' => 'comments',
			'id' => 'comments',
			'type' => 'text',
			'value' => $this->input->post('comments')
		);
		
		$this->data['att'] = $this->input->post('att');
    
		$this->load->view('templates/header', $this->data);
		$this->load->view('forms/ratecampus', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	else {
		if ($this->form_validation->run() == true && $this->data['campus']){
			$att_arr = $this->input->post('att');
			$comments = $this->input->post('comments');

		
			$this->forms_model->save_campus_rating($this->data['campus']->university_id, $att_arr, $comments);

			$this->load->view('templates/header', $this->data);
			$this->load->view('forms/ratecampusthanks', $this->data);
			$this->load->view('templates/footer', $this->data);
		}else{
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

		$this->data['comments'] = array('name' => 'comments',
			'id' => 'comments',
			'type' => 'text',
			'value' => $this->form_validation->set_value('comments'),
		);
    
		$this->load->view('templates/header', $this->data);
		$this->load->view('forms/ratecampus', $this->data);
		$this->load->view('templates/footer', $this->data);
		} 
  }
}

  public function share($slug='')
  {
    if($this->ion_auth->logged_in()) {
  	  $this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $slug));
    	$this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->data['item']->university_id));
    	$this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
    	$this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => $this->data['item']->category_id));


    	if($this->data['item'])
    	  $this->data['title'] = 'Share '.$this->data['item']->item_name.' Ratings';
      else
      	show_404();
  
      //set the flash data error message if there is one
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $this->load->view('templates/header', $this->data);
      $this->load->view('forms/share', $this->data);
      $this->load->view('templates/footer', $this->data);
    }
    else{
        $this->load->helper('cookie');
        $cookie = array(
          'name'   => 'redirect_url',
          'value'  => current_url(),
          'expire' => '3600'
        );
        set_cookie($cookie);
    		$this->data['title'] = "Login";
  		  $this->data['location'] = $this->uri->uri_string();
    		$this->data['message'] = "<li>You must be logged in to rate stuff. Don't worry, we never show your username with any ratings.</li><br /><br />";
    		$this->load->view('templates/header', $this->data);
    		$this->load->view('auth/login', $this->data);
    		$this->load->view('templates/footer', $this->data);
    	}
  }
  
  public function sharethanks($slug='')
  {
    $this->data['title'] = 'Rating Submitted';
  	$this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $slug));
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->data['item']->university_id));
    $this->data['category'] = $this->campus_model->get_single('category', array('category_id' => $this->data['item']->category_id));
    $this->data['attributes'] = $this->campus_model->get_list('attribute', array('category_id' => $this->data['item']->category_id));

    //validate form input
    $this->form_validation->set_rules('name', 'your name', 'required');
    $this->form_validation->set_rules('email', 'email address', 'required|valid_email');
    $this->form_validation->set_rules('name2', "friend's name", 'required');
    $this->form_validation->set_rules('email2', 'email address', 'required|valid_email');
	
	// captcha
	//require_once('/Applications/MAMP/htdocs/baconrings/application/views/forms/recaptchalib.php');
	require_once('/home/peruta/dev.baconrings.com/application/views/forms/recaptchalib.php');
	$privatekey = "6Lc27NgSAAAAAH1q-aJOpzUAESS30J-E5I_WV1Q_";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	$this->data['resp'] = $resp;
	if (!$resp->is_valid) {
	  $this->data['message'] = "<li>Captcha was incorrect.</li>";
	  
	  $this->data['name'] = array('name' => 'name',
      'id' => 'name',
      'type' => 'text',
      'value' => $this->input->post('name')
    );
    
    $this->data['email'] = array('name' => 'email',
      'id' => 'email',
      'type' => 'text',
      'value' => $this->input->post('email')
    );
    
    $this->data['name2'] = array('name' => 'name2',
      'id' => 'name2',
      'type' => 'text',
      'value' => $this->input->post('name2')
    );
    
    $this->data['email2'] = array('name' => 'email2',
      'id' => 'email2',
      'type' => 'text',
      'value' => $this->input->post('email2')
    );
    
    $this->data['comments'] = array('name' => 'comments',
      'id' => 'comments',
      'type' => 'text',
      'value' => $this->input->post('comments')
    );
    
    //$this->data['att'] = $this->input->post('att');

     $this->load->view('templates/header', $this->data);
     $this->load->view('forms/share', $this->data);
     $this->load->view('templates/footer', $this->data);
   }
   else {

    $this->form_validation->set_error_delimiters('<li>','</li>');

    if ($this->form_validation->run() == true && $this->data['item'])
    {
        $name1 = $this->input->post('name');
        $name2 = $this->input->post('name');
        $to = $this->input->post('email2');
        $from = $this->input->post('email');
        $comments = $this->input->post('comments');
        
        $subject = "RateMyCampus share form";
        $emailmessage = $name1. " wants to share ratings with you on RateMyCampus.\n\n";
        $emailmessage .= "\"".$comments."\"\n\n";
        $emailmessage .= "Check out ".$this->data['item']->item_name." at ".$this->data['campus']->university_name.":\n";
        $emailmessage .= base_url().$this->data['campus']->university_slug."/".$this->data['category']->category_slug."/".$this->data['item']->item_slug;

        $headers = "From:" . $from;
        mail($to,$subject,$emailmessage,$headers);
      
        $this->load->view('templates/header', $this->data);
        $this->load->view('forms/sharethanks', $this->data);
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
        'value' => $this->input->post('email')
      );

      $this->data['name2'] = array('name' => 'name2',
        'id' => 'name2',
        'type' => 'text',
        'value' => $this->input->post('name2')
      );

      $this->data['email2'] = array('name' => 'email2',
        'id' => 'email2',
        'type' => 'text',
        'value' => $this->input->post('email2')
      );
      
      $this->data['comments'] = array('name' => 'comments',
        'id' => 'comments',
        'type' => 'text',
        'value' => $this->input->post('comments')
      );

       $this->load->view('templates/header', $this->data);
       $this->load->view('forms/share', $this->data);
       $this->load->view('templates/footer', $this->data);
    }  
  }
}
}
