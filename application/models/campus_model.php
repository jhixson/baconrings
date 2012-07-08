<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campus_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	// Get all campuses
	public function get_list($table, $where = array(), $limit = 100000, $offset = 0, $order_by = '') {
  	if(!empty($order_by))
  	  $this->db->order_by($order_by, "asc");
		return $this->db->get_where($table, $where, $limit, $offset)->result();
	}
	
	// Get a single campus
	public function get_single($table, $where = array(), $limit = 1, $offset = 0) {
		return $this->db->get_where($table, $where, $limit, $offset)->row();
	}
	
	public function get_categories($university_id) {
	  $this->db->select('item.item_id, item.item_name, category.category_id, category.category_name, category.category_color1, category.category_color2, university.university_id, university.university_name');
    $this->db->from('item');
    $this->db->join('university', 'item.university_id = university.university_id', 'inner');
    $this->db->join('category', 'item.category_id = category.category_id', 'inner');
    $this->db->where('university.university_id', $university_id);
    $this->db->group_by('category.category_name');
    
    //$query = $this->db->get();
    //die($this->db->last_query());

    return $this->db->get()->result();
	}
	
	public function get_rating($university_id, $category_id) {
	  $this->db->select('item.item_id, rating.rating_id, attributerating.attributerating_rating, avg(attributerating.attributerating_rating) as score, count(*) as total');
    $this->db->from('item');
    $this->db->join('rating', 'item.item_id = rating.item_id', 'inner');
    $this->db->join('attributerating', 'rating.rating_id = attributerating.rating_id', 'inner');
    $this->db->where('item.category_id', $category_id); 
    $this->db->where('item.university_id', $university_id); 

    return $this->db->get()->row();
	}
	
	public function best_thing($arr) {
	  uasort($arr, function($a, $b) {
	    return $a->score <= $b->score;
	  });
    return key($arr);
	}
	
	public function worst_thing($arr) {
	  uasort($arr, function($a, $b) {
	    return $a->score >= $b->score;
	  });
    return key($arr);
	}
}