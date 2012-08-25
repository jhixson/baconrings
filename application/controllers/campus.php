<?php

class Campus extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->library('ion_auth');
		
		$this->load->model('campus_model');
	}

	public function find()
	{
  	$this->data['title'] = 'Find Your Campus';
  	
  	//$user = $this->facebook->getUser();
  	//$this->data['user_profile'] = $user;
  	
  	$this->data['recent_campuses'] = $this->campus_model->get_list('university', array(), 5, 0, 'university_id', 'desc');

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
  	  $categories[$category->category_name] = (object)$this->campus_model->get_rating_for_category($this->data['campus']->university_id, $category->category_id);
  	  $categories[$category->category_name]->color = $category->category_color2;
  	  $categories[$category->category_name]->slug = $category->category_slug;
    }

    $this->data['overall_rating'] = $this->campus_model->get_rating_for_campus($this->data['campus']->university_id);
  	
  	$this->data['best_thing'] = $this->campus_model->best_thing($categories);
  	$this->data['worst_thing'] = $this->campus_model->worst_thing($categories);
  	
  	$this->data['category_ratings'] = $categories;
  	
  	$recent_ratings = $this->campus_model->get_recent_ratings($this->data['campus']->university_id);
  	$recent_items = $this->campus_model->get_recent_items($this->data['campus']->university_id);
  	
  	$activity = array();
  	foreach($recent_ratings as $recent) {
  	  $activity[] = $recent;
  	}
  	
  	foreach($recent_items as $recent) {
  	  $activity[] = $recent;
  	}
  	
  	$dates = array();
  	foreach($activity as $key => $ac) {
  	  $dates[$key] = $ac->item_dateadded;
  	}
  	
  	array_multisort($dates, SORT_DESC, $activity);
  	
  	$this->data['recent_activity'] = array_slice($activity, 0, 5);
  	
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
  	
  	$items = array();
  	foreach($this->data['items'] as $item) {
      $items[$item->item_name] = (object)$this->campus_model->get_rating_for_item($item->item_id);
      $items[$item->item_name]->total = $this->campus_model->get_num_ratings_for_item($item->item_id);
      if($items[$item->item_name]->total == 0)
        $items[$item->item_name]->score = 0;
  	  $items[$item->item_name]->slug = $item->item_slug;
  	}
  	
  	//print_r($items);
  	//die();
  	
  	$this->data['item_ratings'] = $items;
  	
  	if($this->data['items'])
  	  $this->data['title'] = $this->data['category']->category_name . " at " . $this->data['campus']->university_name;
  	else
    	show_404(); // instead of this we need a "no items found message"
  	
	  $this->load->view('templates/header', $this->data);
  	$this->load->view('campus/category', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
	
	public function item($campus_slug, $category_slug, $item_slug) {
	  $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $campus_slug));
  	$this->data['category'] = $this->campus_model->get_single('category', array('category_slug' => $category_slug));
  	$this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $item_slug, 'category_id' => $this->data['category']->category_id, 'university_id' => $this->data['campus']->university_id));
  	
  	if($this->data['item'])
  	  $this->data['title'] = "Ratings for " . $this->data['item']->item_name . " at " . $this->data['campus']->university_name;
  	else
    	show_404(); // instead of this we need a "no items found message"
    	
  	$this->data['overall_rating'] = $this->campus_model->get_rating_for_item($this->data['item']->item_id);
  	$this->data['num_ratings'] = $this->campus_model->get_num_ratings_for_item($this->data['item']->item_id);
    $this->data['item_ratings'] = $this->campus_model->get_attribute_ratings($this->data['item']->item_id);

    $rankings = $this->campus_model->get_ranking($this->data['item']->university_id, $this->data['item']->category_id);
    $this->data['ranking'] = 1;
    foreach($rankings as $k => $ranking) {
      if($ranking->item_id == $this->data['item']->item_id)
        $this->data['ranking'] += $k;
    }
    //print_r($ranking);
    //die();

    $user = $this->ion_auth->user()->row();
    $this->data['is_favorite'] = $this->ion_auth->logged_in() && $this->campus_model->is_favorite($user->id, $this->data['item']->item_id);
	
  	$comments_list = $this->campus_model->get_list('rating', array('item_id' => $this->data['item']->item_id));
  	$comments = array();
  	foreach($comments_list as $c) {
  	  $comments[$c->rating_id]->ratings = $this->campus_model->get_user_ratings($c->item_id, $c->rating_id);
  	  $comments[$c->rating_id]->comment_text = $c->rating_comments;
  	  $comments[$c->rating_id]->rating_date = $c->rating_date;
	  }
	  
	  //print_r($comments);
  	//die();
  	
  	$this->data['comments'] = $comments;
  		  
	  $this->load->view('templates/header', $this->data);
  	$this->load->view('campus/item', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
	
  // best of
  public function bestof($slug='')
  {
	  if($this->input->post('school'))
  	  redirect(base_url().'best-of/'.$this->input->post('school'), 'location');

    $this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $slug));
    $university_id = $this->data['campus'] ? $this->data['campus']->university_id : '';
    if($this->data['campus'])
      $this->data['title'] = 'Best of '.$this->data['campus']->university_name;
    else
      $this->data['title'] = 'Best of all Schools';
    
    //$this->campus_model->get_rating_for_all('1');
    $this->data['categories'] = $this->campus_model->get_list('category');
    
    foreach($this->data['categories'] as $category) {
      $category->best_of = $this->campus_model->best_of($category->category_id, $university_id);
    }
    
    //print_r($this->data['categories']);
  	//die();
        
    $this->load->view('templates/header', $this->data);
    $this->load->view('campus/bestof', $this->data);
    $this->load->view('templates/footer', $this->data);
  }
  

  // favorites for schools
  public function favorites()
  {
    if($this->ion_auth->logged_in()) {
      $this->data['title'] = 'My Favorites';

      $user = $this->ion_auth->user()->row();
      $faves = $this->campus_model->get_fave_schools($user->id); // replace with proper user_id

      $favorites = array();
      foreach($faves as $fave) {
        $favorites[$fave->university_name][] = $fave;
      }

      //die(print_r($favorites, true));
      $this->data['favorites'] = $favorites;


      $this->load->view('templates/header', $this->data);
      $this->load->view('campus/favorites', $this->data);
      $this->load->view('templates/footer', $this->data);
    }
    else
      redirect('/login','location');
  }


	// trying to figure out facebook login
	public function fb()
	{
		
	  if( ! $this->ion_auth->logged_in() ) {
	    
			$result = $this->facebook->connect();
			
			$user = $result['user'];
			$token = $result['token'];
			if( ! $this->facebook->login($user, $token) ) {
				redirect( 'auth', 'refresh' );
			}
		} else {
			
			$result = $this->facebook->connect();
			
			$user = $this->ion_auth->user()->row();
			
			// Before connecting this user with their Facebook account,
			// we need to ensure the account isn't already tied to another Moodshots account
			$query = $this->db->get_where('users', array('facebook_id' => $result['user']->id));
			if( count($query->result()) == 0 ) {
				$data = array(
					'facebook_id' => $result['user']->id,
					'facebook_token' => $result['token']
				);
				
				$this->ion_auth->update($user->id, $data);
				$this->session->set_userdata('messages', array(array('type' => 'message', 'content' => 'Successfully logged in.')));
			} else {
				$this->session->set_userdata('messages', array(array('type' => 'error', 'content' => 'That Facebook account is already associated with an account. Logout and log in via Facebook to access it.')));
			}
			//redirect( 'settings', 'refresh' );
		
		}
		
    $this->load->view('templates/header', $this->data);
  	$this->load->view('campus/fb', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
}
