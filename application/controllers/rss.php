<?php

class Rss extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
	
		$this->load->model('campus_model');
	}

	function index(){
		// main rss feed
		$comments = $this->campus_model->get_all_comments();

		$now = date("D, d M Y H:i:s T");

		$output = "<?xml version=\"1.0\"?>
				<rss version=\"2.0\">
				<channel>
                    <title>RateMyCampus RSS Feed</title>
                    <link>". base_url()."</link>
                    <description>RateMyCampus RSS Feed</description>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate>	";


        echo $output; 

			foreach($comments as $c){
				// get names
				$user = $this->campus_model->get_user_name($c['users_id']);
				if(empty($user[0]['username'])){ $user[0]['username'] = "user";}

				$item_name = $this->campus_model->get_item_name($c['item_id']);
				//if(empty($item_name[0]['item_slug'])){ $item_name[0]['item_slug'] = "item-slug";}
				
				$school = $this->campus_model->get_school_name($c['university_id']);
				if(empty($school[0]['university_slug'])){
						$school = $this->campus_model->get_school_name($item_name[0]['university_id']);
				}
				
				// must check if it belongs somewhere
				if(!empty($item_name[0]['category_id'])){
					$category = $this->campus_model->get_category_name($item_name[0]['category_id']);
				}

				
				$timestamp = strtotime($c['rating_date']); 
				$time2 = date('D, d M Y H:i:s T', $timestamp); 
				

				echo "<item><title>";
				//echo "Comment by ". $user[0]['username'];
				echo $school[0]['university_name'];
				if(!empty($item_name)){ echo " - ".$item_name[0]['item_name'];}
				echo "</title><description>";
				echo $c['rating_comments'];
				echo "</description><link>";
				echo base_url();
				//echo $school[0]['university_slug'];
				if(empty($school[0]['university_slug'])){ $school[0]['university_slug'] = "university-slug"; echo $school[0]['university_slug'];}else{ echo $school[0]['university_slug'];}
				//if(empty($item_name[0]['item_slug'])){ $item_name[0]['item_slug'] = "item-slug"; echo "/" . $item_name[0]['item_slug'];}
				if(!empty($category)){ echo "/". $category[0]['category_slug'];}
				if(!empty($item_name)){ echo "/".$item_name[0]['item_slug'];}
				
				echo "</link><pubDate>";
				echo $time2;
				echo "</pubDate></item>";

			}

			echo "</channel>
			</rss>";
		
	}
	
	function school(){
		// pull a schools rss feed
		$school = $this->uri->segment(3); 
		
		$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $school));
		$this->data['campus_ratings'] = $this->campus_model->get_attribute_ratings_for_campus($this->data['campus']->university_id);
		
		
		$overall_rating = new stdClass;
		$overall_rating->score = 0;
		$totes = 0;
		foreach($this->data['campus_ratings'] as $r) {
			$totes += $r->score;
		}
		$count = !empty($this->data['campus_ratings']) ? count($this->data['campus_ratings']) : 1;
		$overall_rating->score = $totes / $count;
		$overall_rating->total = $this->campus_model->get_num_ratings_for_campus($this->data['campus']->university_id);
		$overall = ($overall_rating->score / 5.0) * 100;
		$overall_num = number_format($overall_rating->score, 1, '.', ',');
		
		$now = date("D, d M Y H:i:s T");
		
		// categories
		$this->data['categories'] = $this->campus_model->get_categories($this->data['campus']->university_id);
		$categories = array();
		foreach($this->data['categories'] as $category) {
			$categories[$category->category_name] = (object)$this->campus_model->get_rating_for_category($this->data['campus']->university_id, $category->category_id);
			$categories[$category->category_name]->color = $category->category_color2;
			$categories[$category->category_name]->slug = $category->category_slug;
		}
		$this->data['category_ratings'] = $categories;
		
		$output = "<?xml version=\"1.0\"?>
				<rss version=\"2.0\">
				<channel>
                    <title>". $this->data['campus']->university_name ." RateMyCampus RSS Feed</title>
                    <link>". base_url()."$school</link>
                    <description>".$this->data['campus']->university_name ." RateMyCampus RSS Feed</description>
					<image>
						<url>". base_url()."photos/campus/$school.jpg</url>
						<title>". $this->data['campus']->university_name ."</title>
						<link>". base_url()."$school</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate> 
					
					<item>
						<title>Overall Rating</title>
						<description>".$overall_num."</description>
					</item>
					
					";
					

		echo $output;
		/*foreach($this->data['campus_ratings'] as $ratings){
			//echo $ratings->attribute_name;
			echo  "<item><title>";
			echo $ratings->attribute_name;
			echo "</title><description>";
			$score = number_format($ratings->score, 1, '.', ','); 
			echo $score; 
			echo " </description></item>";

		}*/
		
		/*foreach($this->data['category_ratings'] as $categories){
			echo  "<item><title>";
			echo $categories->slug;
			echo "</title><description>";
			$score = number_format($categories->score, 1, '.', ','); 
			echo $score; 
			echo " </description></item>";
		}*/
		//print_r($this->data['category_ratings']);
		
		echo "</channel>
			</rss>";
		
					
	}
	
	function dorm(){
		$school = $this->uri->segment(3);
		$dorm = $this->uri->segment(4); 
		$item_slug = $this->uri->segment(4);
		
		$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $school));
		$this->data['category'] = $this->campus_model->get_single('category', array('category_slug' => "dorms"));
		$this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $item_slug, 'category_id' => $this->data['category']->category_id, 'university_id' => $this->data['campus']->university_id));
		
		//echo $this->data['title'] = "Ratings for " . $this->data['item']->item_name . " at " . $this->data['campus']->university_name;
		
		$this->data['overall_rating'] = $this->campus_model->get_rating_for_item($this->data['item']->item_id);
		if(!isset($this->data['overall_rating']->score)) {
			$this->data['overall_rating'] = new stdClass;
			$this->data['overall_rating']->score = 0;
		}
		$this->data['num_ratings'] = $this->campus_model->get_num_ratings_for_item($this->data['item']->item_id);
		$this->data['item_ratings'] = $this->campus_model->get_attribute_ratings($this->data['item']->item_id);
		
		/*
		$rankings = $this->campus_model->get_ranking($this->data['item']->university_id, $this->data['item']->category_id);
		$this->data['ranking'] = 1;
		foreach($rankings as $k => $ranking) {
			if($ranking->item_id == $this->data['item']->item_id)
				$this->data['ranking'] += $k;
		}
	*/
		$overall_num = number_format($this->data['overall_rating']->score, 1, '.', ',');

		$comments_list = $this->campus_model->get_list('rating', array('item_id' => $this->data['item']->item_id));
  	$comments = array();
  	foreach($comments_list as $c) {
  	  $comments[$c->rating_id]->ratings = $this->campus_model->get_user_ratings($c->item_id, $c->rating_id);
  	  if(isset($ratings[0]))
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
		$link = base_url()."$school/dorms/$dorm";
		$now = date("D, d M Y H:i:s T");
		$output = "<?xml version=\"1.0\"?>
				<rss version=\"2.0\">
				<channel>
                    <title>". $this->data['item']->item_name ." at ". $this->data['campus']->university_name ." RateMyCampus RSS Feed</title>
                    <link>". base_url()."$school/dorms/$dorm</link>
                    <description>".$this->data['item']->item_description ." </description>
					<image>
						<url>". base_url()."photos/$school/". $this->data['item']->item_photo ."</url>
						<title>". $this->data['item']->item_name ."</title>
						<link>". base_url()."$school/dorms/$dorm</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate>
					";

					/*<item>
						<title>Overall Rating</title>
						<description>".$overall_num."</description>
					</item>
					*/

					echo $output;
					foreach($this->data['comments'] as $cc){
						$timestamp = strtotime($cc->rating_date); 
						$time2 = date('D, d M Y H:i:s T', $timestamp);
//print_r($cc);
		echo  "<item><title>Comment by ";
		 if(isset($cc->account_type) && $cc->account_type == "Alumni"){
      	    $who = "an alumnus";
      	 } else{
         	  $who = isset($cc->account_type) ? strtolower("a ".$cc->account_type) : "a user";
         	  
         	  }
         	  echo $who;
         	  
						//echo $item_rating->attribute_name;
						echo "</title>";
						echo "<pubDate>";
						echo $time2;
						echo "</pubDate>";
						echo "<description>";
						
						//echo $cc->rating_comments;
						echo $cc->comment_text;
						echo "</description></item>";
						
			
			}

					/*foreach($this->data['item_ratings'] as $item_rating){
						echo  "<item><title>";
						echo $item_rating->attribute_name;
						echo "</title><description>";
						$score = number_format($item_rating->score, 1, '.', ','); 
						echo $score; 
						echo " </description></item>";
					}*/
					echo "</channel>
						</rss>";
	}
	
	function category(){
		// rss/category/school/item_name
		$category = $this->uri->segment(2); 
		$school = $this->uri->segment(3);
		$item_slug = $this->uri->segment(4);
		
		$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $school));
		$this->data['category'] = $this->campus_model->get_single('category', array('category_slug' => $category));
		$this->data['item'] = $this->campus_model->get_single('item', array('item_slug' => $item_slug, 'category_id' => $this->data['category']->category_id, 'university_id' => $this->data['campus']->university_id));
		
		//echo $this->data['title'] = "Ratings for " . $this->data['item']->item_name . " at " . $this->data['campus']->university_name;
		
		$this->data['overall_rating'] = $this->campus_model->get_rating_for_item($this->data['item']->item_id);
		if(!isset($this->data['overall_rating']->score)) {
			$this->data['overall_rating'] = new stdClass;
			$this->data['overall_rating']->score = 0;
		}
		$this->data['num_ratings'] = $this->campus_model->get_num_ratings_for_item($this->data['item']->item_id);
		$this->data['item_ratings'] = $this->campus_model->get_attribute_ratings($this->data['item']->item_id);
		
		/*
		$rankings = $this->campus_model->get_ranking($this->data['item']->university_id, $this->data['item']->category_id);
		$this->data['ranking'] = 1;
		foreach($rankings as $k => $ranking) {
			if($ranking->item_id == $this->data['item']->item_id)
				$this->data['ranking'] += $k;
		}
	*/
		$comments_list = $this->campus_model->get_list('rating', array('item_id' => $this->data['item']->item_id));
  	$comments = array();
  	foreach($comments_list as $c) {
  	  $comments[$c->rating_id]->ratings = $this->campus_model->get_user_ratings($c->item_id, $c->rating_id);
  	  if(isset($ratings[0]))
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


		$overall_num = number_format($this->data['overall_rating']->score, 1, '.', ',');
	
		$now = date("D, d M Y H:i:s T");
		$output = "<?xml version=\"1.0\"?>
				<rss version=\"2.0\">
				<channel>
                    <title>". $this->data['item']->item_name ." at ". $this->data['campus']->university_name ." RateMyCampus RSS Feed</title>
                    <link>". base_url()."$school/$category/$item_slug</link>
                    <description>".$this->data['item']->item_description ."</description>
					<image>
						<url>". base_url()."photos/$school/". $this->data['item']->item_photo ."</url>
						<title>". $this->data['item']->item_name ."</title>
						<link>". base_url()."$school/$category/$item_slug</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate>
					
					";
					/*
					<item>
						<title>Overall Rating</title>
						<description>".$overall_num."</description>
					</item>
					*/
					echo $output;
					/*foreach($this->data['item_ratings'] as $item_rating){
						echo  "<item><title>";
						echo $item_rating->attribute_name;
						echo "</title><description>";
						$score = number_format($item_rating->score, 1, '.', ','); 
						echo $score; 
						echo " </description></item>";
					}*/

$i = 0;

		foreach($this->data['comments'] as $cc){
//print_r($cc);
		echo  "<item><title>Comment by ";
		 if(isset($cc->account_type) && $cc->account_type == "Alumni"){
      	    $who = "an alumnus";
      	 } else{
         	  $who = isset($cc->account_type) ? strtolower("a ".$cc->account_type) : "a user";
         	  
         	  }
         	  echo $who;
         	  
						//echo $item_rating->attribute_name;
						echo "</title><description>";
						//echo $cc->rating_comments;
						echo $cc->comment_text;
						echo " </description></item>";
						//echo "<pubDate>";
						//echo date("m/d/Y",strtotime($cc->rating_date));
						//echo "</pubDate>";
			
			}

					echo "</channel>
						</rss>";
						
						
	}
	
	function comments(){
		// rss/school/comments
		$school = $this->uri->segment(2);
		$this->data['campus'] = $this->campus_model->get_single('university', array('university_slug' => $school));
		$this->data['campus_rating_comments'] = $this->campus_model->get_ratings_for_campus($this->data['campus']->university_id);
	
		
		//print_r($this->data['campus']);
		
		$now = date("D, d M Y H:i:s T");
		$output = "<?xml version=\"1.0\"?>
				<rss version=\"2.0\">
				<channel>
                    <title>Comments on ". $this->data['campus']->university_name ." RateMyCampus RSS Feed</title>
                    <link>". base_url()."$school</link>
                    <description>Comments on ".$this->data['campus']->university_name ." RateMyCampus RSS Feed</description>
				<image>
						<url>". base_url()."photos/campus/$school.jpg</url>
						<title>". $this->data['campus']->university_name ."</title>
						<link>". base_url()."$school</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate> 
					";
		echo $output;
		$i = 0;
		foreach($this->data['campus_rating_comments'] as $cc){
		echo  "<item><title>Comment by ";
		 if(isset($cc->account_type) && $cc->account_type == "Alumni"){
      	    $who = "an alumnus";
      	 } else{
         	  $who = isset($cc->account_type) ? strtolower("a ".$cc->account_type) : "a user";
         	  
         	  }
         	  echo $who;


         	  
						//echo $item_rating->attribute_name;
						echo "</title>";
						$timestamp = strtotime($cc->rating_date); 
						$time2 = date('D, d M Y H:i:s T', $timestamp);
						echo "<pubDate>";
						echo $time2;
						echo "</pubDate><description>";
						echo $cc->rating_comments;
						echo " </description></item>";
						//echo "<pubDate>";
						//echo date("m/d/Y",strtotime($cc->rating_date));
						//echo "</pubDate>";
			
			}


	
		echo "</channel>
						</rss>";	
			
	}
	
}
?>