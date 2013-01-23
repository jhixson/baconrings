<?php

class Rss extends MY_Controller {
  
  function __construct()
	{
		parent::__construct();
	
		$this->load->model('campus_model');
	}

	function index(){
		// main rss feed
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
                    <title>". $this->data['campus']->university_name ." RSS Feed</title>
                    <link>". base_url()."$school</link>
                    <description>".$this->data['campus']->university_name ." RSS Feed</description>
					<image>
						<url>". base_url()."photos/campus/$school.jpg</url>
						<title>". $this->data['campus']->university_name ."</title>
						<link>". base_url()."$school</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate> 
                    <lastBuildDate>".$now."</lastBuildDate>
					
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
	
		$now = date("D, d M Y H:i:s T");
		$output = "<?xml version=\"1.0\"?>
				<rss version=\"2.0\">
				<channel>
                    <title>". $this->data['item']->item_name ." at ". $this->data['campus']->university_name ." RSS Feed</title>
                    <link>". base_url()."$school/dorms/$dorm</link>
                    <description>".$this->data['item']->item_description ."</description>
					<image>
						<url>". base_url()."photos/$school/". $this->data['item']->item_photo ."</url>
						<title>". $this->data['item']->item_name ."</title>
						<link>". base_url()."$school/dorms/$dorm</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate> 
                    <lastBuildDate>".$now."</lastBuildDate>
					
					<item>
						<title>Overall Rating</title>
						<description>".$overall_num."</description>
						<pubDate>".$now."</pubDate>
					</item>
					
					";
					echo $output;
					foreach($this->data['item_ratings'] as $item_rating){
						echo  "<item><title>";
						echo $item_rating->attribute_name;
						echo "</title><description>";
						$score = number_format($item_rating->score, 1, '.', ','); 
						echo $score; 
						echo " </description></item>";
					}
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
		$overall_num = number_format($this->data['overall_rating']->score, 1, '.', ',');
	
		$now = date("D, d M Y H:i:s T");
		$output = "<?xml version=\"1.0\"?>
				<rss version=\"2.0\">
				<channel>
                    <title>". $this->data['item']->item_name ." at ". $this->data['campus']->university_name ." RSS Feed</title>
                    <link>". base_url()."$school/$category/$item_slug</link>
                    <description>".$this->data['item']->item_description ."</description>
					<image>
						<url>". base_url()."photos/$school/". $this->data['item']->item_photo ."</url>
						<title>". $this->data['item']->item_name ."</title>
						<link>". base_url()."$school/$category/$item_slug</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate> 
                    <lastBuildDate>".$now."</lastBuildDate>
					
					<item>
						<title>Overall Rating</title>
						<description>".$overall_num."</description>
						<pubDate>".$now."</pubDate>
					</item>
					
					";
					echo $output;
					foreach($this->data['item_ratings'] as $item_rating){
						echo  "<item><title>";
						echo $item_rating->attribute_name;
						echo "</title><description>";
						$score = number_format($item_rating->score, 1, '.', ','); 
						echo $score; 
						echo " </description></item>";
					}
					echo "</channel>
						</rss>";
						
						print_r($this->data['category']);
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
                    <title>Comments on ". $this->data['campus']->university_name ." RSS Feed</title>
                    <link>". base_url()."$school</link>
                    <description>Comments on ".$this->data['campus']->university_name ."</description>
				<image>
						<url>". base_url()."photos/campus/$school.jpg</url>
						<title>". $this->data['campus']->university_name ."</title>
						<link>". base_url()."$school</link>
					</image>
                    <language>en-us</language>
                    <pubDate>".$now."</pubDate> 
                    <lastBuildDate>".$now."</lastBuildDate>
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
						echo "</title><description>";
						echo $cc->rating_comments;
						echo " </description></item>";
						echo "<pubDate>";
						echo date("m/d/Y",strtotime($cc->rating_date));
						echo "</pubDate>";
			
			}
	
		echo "</channel>
						</rss>";	
			
	}
	
}
?>