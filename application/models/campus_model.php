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
	  $this->db->select('item.item_id, item.item_name, category.category_id, category.category_name, category.category_slug, category.category_color1, category.category_color2, university.university_id, university.university_name');
    $this->db->from('item');
    $this->db->join('university', 'item.university_id = university.university_id', 'inner');
    $this->db->join('category', 'item.category_id = category.category_id', 'inner');
    $this->db->where('university.university_id', $university_id);
    $this->db->group_by('category.category_name');

    return $this->db->get()->result();
	}
	
	public function get_rating_for_category($university_id, $category_id) {
    $sql = "select avg(ar) as score, count(*) as total from (SELECT item.item_id, rating.rating_id, attributerating.attributerating_rating as ar
    FROM  `item` 
    INNER JOIN rating ON ( item.item_id = rating.item_id ) 
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id ) 
    WHERE item.category_id = ?
    AND item.university_id = ?
    GROUP BY rating.rating_id) as x";

    return $this->db->query($sql, array($category_id, $university_id))->row();
	}
	
	public function get_rating_for_item($item_id) {
    $sql = "select item.item_id, rating.rating_id, AVG( attributerating.attributerating_rating ) AS score, attribute.attribute_name
    FROM  `item` 
    INNER JOIN rating ON ( item.item_id = rating.item_id ) 
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id
    AND item.item_id = rating.item_id ) 
    INNER JOIN attribute ON ( attribute.category_id = item.category_id
    AND attribute.attribute_id = attributerating.attribute_id ) 
    WHERE item.item_id = ?
    GROUP BY item.item_id";

    return $this->db->query($sql, array($item_id))->row();
	}
  
  public function ger_attribute_ratings($item_id) {
    $sql = "select item.item_id, rating.rating_id, AVG( attributerating.attributerating_rating ) AS score, attribute.attribute_name
    FROM  `item` 
    INNER JOIN rating ON ( item.item_id = rating.item_id ) 
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id
    AND item.item_id = rating.item_id ) 
    INNER JOIN attribute ON ( attribute.category_id = item.category_id
    AND attribute.attribute_id = attributerating.attribute_id ) 
    WHERE item.item_id = ?
    GROUP BY attribute.attribute_name";
    
    //$this->db->query($sql, array($item_id));
    //$query = $this->db->get();
    //die($this->db->last_query());

    return $this->db->query($sql, array($item_id))->result();
	}
	
	public function get_num_ratings_for_item($item_id) {
	  $sql = "select count(*) as total from (SELECT item.item_id, rating.rating_id, attributerating.attributerating_rating as ar
    FROM  `item` 
    INNER JOIN rating ON ( item.item_id = rating.item_id ) 
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id ) 
    WHERE item.item_id = ?
    GROUP BY rating.rating_id) as x";
    
    return $this->db->query($sql, array($item_id))->row()->total;
	}
	
	public function get_user_ratings($item_id, $rating_id) {
	  $sql = "select rating.rating_date, attributerating.attributerating_rating, attribute.attribute_name
    FROM `rating`
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id ) 
    INNER JOIN attribute ON ( attributerating.attribute_id = attribute.attribute_id ) 
    WHERE rating.item_id = ? AND rating.rating_id = ?";
    
    return $this->db->query($sql, array($item_id, $rating_id))->result();
	}
	
	public function get_rating_for_all($category_id) {
	  $this->db->select('item.item_id, rating.rating_id, attributerating.attributerating_rating, avg(attributerating.attributerating_rating) as score, count(rating.rating_id) as total');
    $this->db->from('item');
    $this->db->join('rating', 'item.item_id = rating.item_id', 'inner');
    $this->db->join('attributerating', 'rating.rating_id = attributerating.rating_id', 'inner');
    $this->db->where('item.category_id', $category_id); 
    
    //$query = $this->db->get();
    //die($this->db->last_query());

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


	//for favorites page - schools
	public function get_fave_schools($id) {
	  $this->db->select('university.university_id, university.university_name, university.university_slug');
    $this->db->from('favorites');
    $this->db->join('item', 'favorites.item_id = item.item_id', 'inner');
    $this->db->join('university', 'item.university_id = university.university_id', 'inner');
    $this->db->where('favorites.id', $id);

    return $this->db->get()->result();
	}


	//for favorites page - favorites
	public function get_faves($university_id) {
	  $this->db->select('item.item_name, item.item_slug, category.category_name, category.category_slug');
    $this->db->from('item');
    $this->db->join('category', 'item.category_id = category.category_id', 'inner');
    $this->db->where('item.university_id', $university_id);

    //$query = $this->db->get();
    //die($this->db->last_query());
    
    return $this->db->get()->result();
	}




}