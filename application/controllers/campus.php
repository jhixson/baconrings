<?php

class Campus extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');
		$this->load->model('campus_model');
	}

	public function find()
	{
  	$this->data['title'] = 'Find Your Campus';
  	
  	$user = $this->facebook->getUser();
  	$this->data['user_profile'] = $user;
  	
  	//$this->data['campuses'] = $this->campus_model->get_list('university', array());

  	$this->load->view('templates/header', $this->data);
  	$this->load->view('campus/find', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
	
	public function view($slug='')
	{
	  if($this->input->post('school'))
  	  redirect(base_url().$this->input->post('school'), 'location');
  	  
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $slug));
  	
  	if($this->data['campus'])
  	  $this->data['title'] = $this->data['campus']->university_name;
  	else
    	show_404();
  	
  	$this->data['categories'] = $this->campus_model->get_categories($this->data['campus']->university_id);
  	
  	$categories = array();
  	foreach($this->data['categories'] as $category) {
  	  $categories[$category->category_name] = $this->campus_model->get_rating($this->data['campus']->university_id, $category->category_id);
  	  $categories[$category->category_name]->color = $category->category_color2;
  	}
  	
  	$this->data['best_thing'] = $this->campus_model->best_thing($categories);
  	$this->data['worst_thing'] = $this->campus_model->worst_thing($categories);
  	
  	$this->data['category_ratings'] = $categories;
  	
	  $this->load->view('templates/header', $this->data);
  	$this->load->view('campus/view', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
	
	public function category($campus_slug, $category_slug)
	{  	
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
  	$this->data['category'] = $this->campus_model->get_single('category', array('category_slug' => $category_slug));
  	
  	if($this->data['campus'] && $this->data['category']) {    	
    	$this->data['items'] = $this->campus_model->get_list('item', array('category_id' => $this->data['category']->category_id, 'university_id' => $this->data['campus']->university_id));
  	}
  	
  	if($this->data['items'])
  	  $this->data['title'] = $this->data['category']->category_name . " at " . $this->data['campus']->university_name;
  	else
    	show_404(); // instead of this we need a "no items found message"
  	
	  $this->load->view('templates/header', $this->data);
  	$this->load->view('campus/category', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
	
  // best of
  public function bestof()
  {
    $this->data['title'] = 'Best of on Campuses';
    
    $this->load->view('templates/header', $this->data);
    $this->load->view('campus/bestof', $this->data);
    $this->load->view('templates/footer', $this->data);
  }
  

  // favorites for schools
  public function favorites()
  {
    $this->data['title'] = 'My Favorites';

    $this->data['faves'] = $this->campus_model->get_fave_schools('2');
    $this->data['favorites'] = $this->campus_model->get_faves('1');

    $favorites = array();
    foreach($this->data['faves'] as $fave) {
      $favorites[$fave->university_name] = $this->campus_model->get_faves($fave->university_id);
    }

    //die(print_r($favorites, true));


    $this->load->view('templates/header', $this->data);
    $this->load->view('campus/favorites', $this->data);
    $this->load->view('templates/footer', $this->data);
  }


	// trying to figure out facebook login
	public function fb()
	{
	  $this->data['title'] = 'Login with Facebook';
	  
	  $user = $this->facebook->getUser();

    if ($user) {
      try {
        $this->data['user_profile'] = $this->facebook->api('/me');
      } catch (FacebookApiException $e) {
        $user = null;
      }
    }

    if ($user) {
      $this->data['logout_url'] = $this->facebook->getLogoutUrl();
    } else {
      $this->data['login_url'] = $this->facebook->getLoginUrl();
    }
    
    //die(print_r($data, true));
    
    $this->load->view('templates/header', $this->data);
  	$this->load->view('campus/fb', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
}