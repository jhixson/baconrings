<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		// Load MongoDB library instead of native db driver if required
		$this->config->item('use_mongodb', 'ion_auth') ?
			$this->load->library('mongo_db') :
			$this->load->database();
	}

	//redirect if needed, otherwise display the user list
	function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect(base_url().'login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			//redirect them to the home page because they must be an administrator to view this
			redirect($this->config->item('base_url'), 'location');
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->load->view('auth/index', $this->data);
		}
	}

	//log the user in
	function login()
	{
		$this->data['title'] = "Login";

    $userId = $this->facebook->getUser();
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		$this->form_validation->set_error_delimiters('<li>','</li>');

		if ($this->form_validation->run() == true)
		{ //check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{ //if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				
				$ref = $this->input->server('HTTP_REFERER');
				if(!empty($ref))
				  redirect($ref, 'location');
				else if($this->ion_auth->user()->row()->university_id != 0) {
          $u = $this->campus_model->get_single('university', array('university_id' => $this->ion_auth->user()->row()->university_id));
				  redirect('/'.$u->university_slug, 'location');
			  }
				else
  				redirect($this->config->item('base_url'), 'refresh');
			}
			else
			{ //if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(base_url().'auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{  //the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
			);

      $this->data['fb_login_url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 

      $this->load->view('templates/header', $this->data);
			$this->load->view('auth/login', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
	}
	
	function fb(){
      // Try to get the user's id on Facebook
    $userId = $this->facebook->getUser();
    //var_dump($userId);
    //die();
    log_message('error', 'FB User: '.$userId);
    
      // If user is not yet authenticated, the id will be zero
      if($userId == 0 && !isset($_GET['code'])){
          // Generate a login url
          $this->data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
          redirect($this->data['url'],'refresh');
      } else {
        $this->data['user'] = $userId;
        log_message('error', 'FB User: '.$userId);
        $query = $this->db->get_where('users', array('facebook_id' => $userId));
        if( count($query->result()) == 0 ) {
          // Get user's data and print it
          $profile = $this->facebook->api('/me');
          $this->data['user_profile'] = $profile;

          $user_data = array(
            'facebook_id' => $userId,
            'facebook_token' => $_GET['code']
          );
          
          $q2 = $this->db->get_where('users', array('email' => $profile['email']));
          if( count($q2->result()) > 0 ) {
            $fb_user_id - $q2->row()->id;
            $this->db->update('users', array('facebook_id' => $userId), array('email' => $profile['email']));
          }
          else
            $fb_user_id = $this->ion_auth->register($profile['username'], '', $profile['email'], $user_data);

        } else {
          $profile['email'] = $query->row()->email;
          $fb_user_id = $query->row()->id;
        }

        $session_data = array(
              'identity' => 'email',
              'email' => $profile['email'],
              'id'                   => $fb_user_id, //kept for backwards compatibility
              'user_id'              => $fb_user_id, //everyone likes to overwrite id so we'll use user_id
          );

          $this->session->set_userdata($session_data);
          
          $this->load->helper('cookie');
          $ref = get_cookie('redirect_url');
          if(!empty($ref)) {
            delete_cookie('redirect_url');
  				  redirect($ref, 'location');
				  }
          else if($query->row()->university_id != 0) {
            $u = $this->campus_model->get_single('university', array('university_id' => $query->row()->university_id));
  				  redirect('/'.$u->university_slug, 'location');
				  }
				  elseif($userId != 0) {
				    redirect('/', 'location');
        	}
      }
      $this->load->view('main/index', $this->data);
      //$this->load->view('templates/header', $this->data);
			//$this->load->view('auth/login', $this->data);
			//$this->load->view('templates/footer', $this->data);
  }

	//log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$this->facebook->destroySession();
    $logout = $this->ion_auth->logout();

		//redirect them back to the page they came from
		redirect(base_url(), 'refresh');
	}

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', 'Old password', 'required');
		$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect(base_url().'auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{ //display the form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->load->view('auth/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{ //if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(base_url().'auth/change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);
			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->view('auth/forgot_password', $this->data);
		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ //if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect(base_url()."auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect(base_url()."auth/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{  //if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

			if ($this->form_validation->run() == false)
			{//display the form
				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->load->view('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_404();

				} else {
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{ //if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect(base_url().'auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{ //if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect(base_url()."auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
			$activation = $this->ion_auth->activate($id, $code);
		else if ($this->ion_auth->is_admin())
			$activation = $this->ion_auth->activate($id);

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect(base_url()."auth", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect(base_url()."auth/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->load->view('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_404();
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect(base_url().'auth', 'refresh');
		}
	}

	//create a new user
	function create_user()
	{
	  $this->load->model('campus_model');
		$this->data['title'] = "Sign Up";

    /*
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect(base_url().'auth', 'refresh');
		}
	  */

		//validate form input
		$this->form_validation->set_rules('school', 'School', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|matches[email2]');
		$this->form_validation->set_rules('email2', 'Email Confirmation', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

		$this->form_validation->set_error_delimiters('<li>','</li>');

		if ($this->form_validation->run() == true)
		{
			//$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email = $this->input->post('email');
			$username = $email;
			$password = $this->input->post('password');

			$additional_data = array('account_type' => $this->input->post('who'), 'university_id' => $this->input->post('school'));

		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
		{ //check to see if we are creating the user
			//redirect them back to the admin page
			
			 // email functionality here
	        $to = $email;
   		    $subject = "Welcome to the RateMyCampus Community";
        	$emailmessage = '<html>

<head>

  <title>Welcome to the RateMyCampus Community</title>

<style>

#container{
	width:650px;
	background-color:#ffffff;
	margin:0 auto;
}

#header{
	width:650px;
	height:82px;
}

#main{
	width:620px;
	padding:15px;
}

#footer{
	width:620px;
	height:40px;
	border-top:4px solid #000000;
	background-color:#9cc24d;
	padding:15px;
}

</style>

</head>

<body bgcolor="#000000">

<div id="container">

	<div id="header"><a href="http://wwww.ratemycampus.com"><img src="http://dev.baconrings.com/images/newsletter_header.gif" alt="ratemycampus.com" border="0" width="650" height="82"></a></div>

	<div id="main" style="font-family:arial;font-size:11pt;">

		<br />

		<span style="font-family:arial;font-size:17pt;letter-spacing:3px">WELCOME</span>

		<p>Thank you for joining the RateMyCampus community! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras auctor ligula sed enim tincidunt placerat. Aenean felis lectus, feugiat et iaculis vel, sollicitudin rutrum magna. Quisque sed sapien id mauris tempor sagittis vitae non augue. Curabitur iaculis placerat mi eget sagittis.</p>

		<p>The RateMyCampus Team</p>

		<br />

		<p align="center">
			<a href="http://dev.baconrings.com/ithaca-college"><img src="http://dev.baconrings.com/images/newsletter_startrating.gif" border="0" width="184" height="42" alt="start rating" hspace="21" /></a>

			<a href="http://dev.baconrings.com"><img src="http://dev.baconrings.com/images/newsletter_findschools.gif" border="0" width="184" height="42" alt="find schools" hspace="21" /></a>
		</p>


	</div>

	<div id="footer" style="font-family:arial;font-size:10pt;line-height:20px;">

		<div id="social" style="float:right;width:52px;">
			<a href=""><img src="http://dev.baconrings.com/images/newsletter_facebook.png" alt="find us on facebook" border="0" width="22" height="22" /></a>
			<a href=""><img src="http://dev.baconrings.com/images/newsletter_twitter.png" alt="we are on twitter" border="0" width="22" height="22" /></a>
		</div>

		<strong><a style="color:#000000;text-decoration:none;" href="http://www.ratemycampus.com">find schools</a>  &nbsp;|&nbsp;  <a style="color:#000000;text-decoration:none;" href="http://www.ratemycampus.com/forms/contact">contact us</a></strong>
		<br />&copy; Copyright 2012. All Rights Reserved. RateMyCampus.com

	</div>

</div>

</body>

</html>';
        	
        	$from = "signup@ratemycampus.com";
        	$headers = "From:" . "signup@ratemycampus.com";
        	mail($to,$subject,$emailmessage,$headers);
        	
			$this->session->set_flashdata('message', "User Created");

			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'))) {
        //redirect(base_url(), 'refresh');
        $this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->input->post('school')));
      	
        $this->load->view('templates/header', $this->data);
  			$this->load->view('auth/thank_you', $this->data);
  			$this->load->view('templates/footer', $this->data);
      }
      else
        redirect(base_url()."auth", 'refresh');
		}
		else
		{ //display the create user form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array('name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array('name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array('name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone1'] = array('name' => 'phone1',
				'id' => 'phone1',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone1'),
			);
			$this->data['phone2'] = array('name' => 'phone2',
				'id' => 'phone2',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone2'),
			);
			$this->data['phone3'] = array('name' => 'phone3',
				'id' => 'phone3',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone3'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array('name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			
			$this->data['campuses'] = $this->campus_model->get_list('university', array(), 100000, 0, 'university_name', 'desc');
			$this->load->view('templates/header', $this->data);
			$this->load->view('auth/create_user', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
