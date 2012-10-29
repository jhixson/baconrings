<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
	}

	// input stuff
	public function input_stuff($table, $data) {
  		$this->db->insert($table, $data);
  }

  public function save_rating($item_id, $attribute_ratings, $comments) {
    if(!empty($item_id) && !empty($attribute_ratings) && !empty($comments)) {
      $user = $this->ion_auth->user()->row();
      $rating_data = array(
        'rating_comments' => $comments,
        'rating_ip' => $_SERVER['REMOTE_ADDR'],
        'users_id' => $user->user_id,
        'item_id' => $item_id,
        'rating_date' => date("Y-m-d H:i:s")
      );
      $this->db->insert('rating', $rating_data);

      $rating_id = $this->db->insert_id();

      foreach($attribute_ratings as $attribute => $rating) {
        $attribute_rating_data = array(
          'rating_id' => $rating_id,
          'attribute_id' => $attribute,
          'attributerating_rating' => $rating
        );
        $attribute_rating_id = $this->db->insert('attributerating', $attribute_rating_data);
      }
    }
  }
	
	
}
