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
  	
  	//die($this->ion_auth->user()->row()->id);
  	  	
  	//$user = $this->facebook->getUser();
  	//$this->data['user_profile'] = $user;
  	
  	//$this->data['recent_campuses'] = $this->campus_model->get_list('university', array(), 5, 0, 'university_id', 'desc');
  	$arr = $this->campus_model->get_recent_campus_ratings();
  	$this->data['recent_campuses'] = array();
  	foreach($arr as $a) {
  	  $temp = new stdClass;
  	  $temp->university_name = $a->university_name;
  	  $temp->university_slug = $a->university_slug;
  	  if(!in_array($temp,$this->data['recent_campuses']))
    	  $this->data['recent_campuses'][] = $temp;
  	}
  	
  	$this->data['recent_campuses'] = array_slice($this->data['recent_campuses'], 0, 5);
  	
  	//die(print_r($recent_campuses, true));
  	
  	$this->load->view('templates/header', $this->data);
  	$this->load->view('campus/find', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
	
	public function view_rating($rating_id) {
	  $this->data['rating'] = $this->campus_model->get_single('rating', array('rating_id' => $rating_id));
	  $this->data['campus'] = $this->campus_model->get_single('university', array('university_id' => $this->data['rating']->university_id));
    $this->data['campus_ratings'] = $this->campus_model->get_attribute_ratings_by_id($rating_id);
	  
	  $this->data['title'] = 'View rating for '.$this->data['campus']->university_name;
    
    //die(print_r($this->data['campus_ratings'],true));
    
    $this->load->view('templates/header', $this->data);
  	$this->load->view('campus/view_rating', $this->data);
  	$this->load->view('templates/footer', $this->data);
	}
	
	public function view($slug='')
	{
	  if($this->input->post('school'))
  	  redirect(base_url().$this->input->post('school'), 'location');
  	  
  	$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $slug));
  	$this->data['campus_ratings'] = $this->campus_model->get_attribute_ratings_for_campus($this->data['campus']->university_id);
  	
  //	die(print_r($this->data['campus_ratings'],true));
  	
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
    
    $user = $this->ion_auth->user()->row();
    $this->data['is_favorite'] = $this->ion_auth->logged_in() && $this->campus_model->is_favorite($user->id, $this->data['campus']->university_id);

    //$this->data['overall_rating'] = $this->campus_model->get_rating_for_campus($this->data['campus']->university_id);
    $this->data['campus_rating_comments'] = $this->campus_model->get_ratings_for_campus($this->data['campus']->university_id);

    $this->data['overall_rating'] = new stdClass;
    $this->data['overall_rating']->score = 0;
    $totes = 0;
    foreach($this->data['campus_ratings'] as $r) {
      $totes += $r->score;
    }
    $count = !empty($this->data['campus_ratings']) ? count($this->data['campus_ratings']) : 1;
    $this->data['overall_rating']->score = $totes / $count;
    $this->data['overall_rating']->total = $this->campus_model->get_num_ratings_for_campus($this->data['campus']->university_id);
  	
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
    if(!isset($this->data['overall_rating']->score)) {
      $this->data['overall_rating'] = new stdClass;
      $this->data['overall_rating']->score = 0;
    }
  	$this->data['num_ratings'] = $this->campus_model->get_num_ratings_for_item($this->data['item']->item_id);
    $this->data['item_ratings'] = $this->campus_model->get_attribute_ratings($this->data['item']->item_id);

    $rankings = $this->campus_model->get_ranking($this->data['item']->university_id, $this->data['item']->category_id);
    $this->data['ranking'] = 1;
    foreach($rankings as $k => $ranking) {
      if($ranking->item_id == $this->data['item']->item_id)
        $this->data['ranking'] += $k;
    }

    $user = $this->ion_auth->user()->row();
    //$this->data['is_favorite'] = $this->ion_auth->logged_in() && $this->campus_model->is_favorite($user->id, $this->data['item']->item_id);
	
  	$comments_list = $this->campus_model->get_list('rating', array('item_id' => $this->data['item']->item_id));
  	$comments = array();
  	foreach($comments_list as $c) {
  	  $comments[$c->rating_id]->ratings = $this->campus_model->get_user_ratings($c->item_id, $c->rating_id);
  	  $first = $comments[$c->rating_id]->ratings[0];
  	  $comments[$c->rating_id]->comment_text = $c->rating_comments;
  	  $comments[$c->rating_id]->rating_date = $c->rating_date;
  	  if(isset($first->account_type) && $first->account_type == "Alumni")
  	    $comments[$c->rating_id]->who = "an alumnus";
  	  else
    	  $comments[$c->rating_id]->who = isset($first->account_type) ? strtolower("a ".$first->account_type) : "a user";
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
      $this->data['title'] = 'Best of All Campuses';
    
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
      $this->data['title'] = 'My Schools';

      $user = $this->ion_auth->user()->row();
      $faves = $this->campus_model->get_fave_schools($user->id); // replace with proper user_id
      
      foreach($faves as $fav) {
        $campus_ratings = $this->campus_model->get_attribute_ratings_for_campus($fav->university_id);
        //$fav->rating = new stdClass;
        $fav->score = 0;
        $totes = 0;
        foreach($campus_ratings as $r) {
          $totes += $r->score;
        }
        $count = !empty($campus_ratings) ? count($campus_ratings) : 1;
        $fav->score = $totes / $count;
      }
      
      //print_r($faves);
      //die();

      $this->data['favorites'] = $faves;

      $this->load->view('templates/header', $this->data);
      $this->load->view('campus/favorites', $this->data);
      $this->load->view('templates/footer', $this->data);
    }
    else {
      //redirect('/login','location');
      $this->data['title'] = "Login";
      $this->data['message'] = '<li>You need to be logged in to use My Schools!</li><br /><br />';
      $this->load->view('templates/header', $this->data);
      $this->load->view('auth/login', $this->data);
      $this->load->view('templates/footer', $this->data);
    }
  }
  
  public function upload($slug='') {
    if($this->ion_auth->logged_in()) {
      $this->data['title'] = 'Upload';
      $this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $slug));
      $this->load->view('templates/header', $this->data);
      $this->load->view('campus/upload', $this->data);
      $this->load->view('templates/footer', $this->data);
    }
    else
      redirect('/login','location');
  }
  
  public function do_upload() {
    $this->data['title'] = 'Upload';
    if($this->ion_auth->logged_in()) {
      
      $this->data['item'] = $this->campus_model->get_single('item', array('item_id' => $this->input->post('item_id')));
    
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'gif|jpg|png';
  		$config['max_size']	= '2048';
  		$config['max_width']  = '1024';
  		$config['max_height']  = '1024';

  		$this->load->library('upload', $config);
  		if ( ! $this->upload->do_upload())
  		{
  			$this->data['msg'] = $this->upload->display_errors();

        $this->load->view('templates/header', $this->data);
  			$this->load->view('campus/upload', $this->data);
  			$this->load->view('templates/footer', $this->data);
  		}
  		else
  		{
  		  $upload_data = $this->upload->data();
  			$this->data['upload_data'] = $upload_data;
			
  			// this is where we would insert the data into the db with filename, item_id, etc
  			// duplicate filenames are automatically handled by codeigniter
  			$user = $this->ion_auth->user()->row();
  			$photo_data = array('photos_filename' => $upload_data['file_name'], 'photos_caption' => $this->input->post('caption'), 'users_id' => $user->id, 'item_id' => $this->input->post('item_id'), 'photos_dateadded' => date('Y-m-d H:i:s'));
  			$uploaded = $this->campus_model->add_photo($photo_data);
  			if(!empty($uploaded))
  			  $this->data['msg'] = 'Upload successful!';
			
    		$this->load->view('templates/header', $this->data);
  			$this->load->view('campus/upload', $this->data);
  			$this->load->view('templates/footer', $this->data);
  		}
		}
    else
      redirect('/login','location');
  }

  public function directory()
  {
    $this->data['title'] = 'Campus and University Directory';
    $campuses = $this->campus_model->get_list('university', array(), 100000, 0, 'university_name', 'desc');
    
    $this->data['campuses'] = array();
    foreach($campuses as $c) {
      $letter = strtoupper(substr($c->university_name, 0, 1));
      $this->data['campuses'][$letter][] = $c;
    }

    //print_r($this->data['campuses']);
    //die();

    $this->load->view('templates/header', $this->data);
    $this->load->view('campus/directory', $this->data);
    $this->load->view('templates/footer', $this->data);
  }

}