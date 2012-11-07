<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campus_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	// Get all campuses
	public function get_list($table, $where = array(), $limit = 100000, $offset = 0, $order_by = '', $order_direction = 'asc') {
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

  public function get_rating_for_campus($university_id) {
    $sql = "select ar as score, count(*) as total from (SELECT item.item_id, rating.rating_id, avg(attributerating.attributerating_rating) as ar
    FROM  `item` 
    INNER JOIN rating ON ( item.item_id = rating.item_id ) 
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id ) 
    WHERE item.university_id = ?
    GROUP BY rating.rating_id) as x";

    return $this->db->query($sql, array($university_id))->row();
	}

	
	public function get_rating_for_category($university_id, $category_id) {
    $sql = "select ar as score, count(*) as total from (SELECT item.item_id, rating.rating_id, avg(attributerating.attributerating_rating) as ar
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
  
  public function get_attribute_ratings($item_id) {
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
	
	public function get_attribute_ratings_for_campus($university_id) {
    $sql = "select university.university_id, rating.rating_id, AVG( attributerating.attributerating_rating ) AS score, attribute.attribute_name
    FROM  `university` 
    INNER JOIN rating ON ( university.university_id = rating.item_id ) 
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id
    AND university.university_id = rating.item_id ) 
    INNER JOIN attribute ON ( attribute.category_id = 0
    AND attribute.attribute_id = attributerating.attribute_id ) 
    WHERE university.university_id = ?
    GROUP BY attribute.attribute_name";

     //$this->db->query($sql, array($item_id));
     //$query = $this->db->get();
     //die($this->db->last_query());

     return $this->db->query($sql, array($university_id))->result();
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
	  $sql = "select rating.rating_date, attributerating.attributerating_rating, attribute.attribute_name, users.account_type
    FROM `rating`
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id ) 
    INNER JOIN attribute ON ( attributerating.attribute_id = attribute.attribute_id ) 
    INNER JOIN users ON ( rating.users_id = users.id )
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
	
	public function best_of($category_id, $university_id='') {
	  $params = array($category_id);
	  $sql = "select item.item_id, item.item_name, item.item_slug, university.university_name, university.university_slug, AVG( attributerating.attributerating_rating ) AS score
        FROM  `item` 
        INNER JOIN rating ON ( item.item_id = rating.item_id ) 
        INNER JOIN university ON ( item.university_id = university.university_id ) 
        INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id AND item.item_id = rating.item_id ) 
        where item.category_id = ?";
    if(!empty($university_id)) {
      $sql .= " and item.university_id = ?";
      array_push($params, $university_id);
    }
        
    $sql .= " GROUP BY item.item_id
    order by score desc
    limit 0, 5";
    
    //$this->db->query($sql, $params);
    //die($this->db->last_query());
    
    return $this->db->query($sql, $params)->result();
  }

  public function get_ranking($university_id, $category_id) {
    $sql = "select item.item_id, rating.rating_id, university.university_id, category.category_id, AVG( attributerating.attributerating_rating ) AS score, attribute.attribute_name
    FROM  `university`, `category`, `item` 
    INNER JOIN rating ON ( item.item_id = rating.item_id ) 
    INNER JOIN attributerating ON ( attributerating.rating_id = rating.rating_id
    AND item.item_id = rating.item_id ) 
    INNER JOIN attribute ON ( attribute.category_id = item.category_id
    AND attribute.attribute_id = attributerating.attribute_id ) 
    where university.university_id = ? and 
    category.category_id = ? and 
    category.category_id = item.category_id and 
    university.university_id = item.university_id
    GROUP BY item.item_id
    order by score desc";

    return $this->db->query($sql, array($university_id, $category_id))->result();
  }
  
  public function get_recent_ratings($university_id) {
    $sql = "select rating.rating_id, rating.rating_date as item_dateadded, item.item_name, item.item_slug, category.category_name, category.category_slug FROM `rating`
    left join item on rating.item_id = item.item_id
    left join category on item.category_id = category.category_id
    where item.university_id = ?
    group by item.item_id
    order by item_dateadded desc
    limit 5";
    
    return $this->db->query($sql, array($university_id))->result();
  }
  
  public function get_recent_items($university_id) {
    $sql = "select item.item_id, item.item_dateadded, item.item_name, item.item_slug, category.category_name, category.category_slug FROM `item`
    left join category on item.category_id = category.category_id
    where item.university_id = ?
    group by item.item_id
    order by item_dateadded desc
    limit 5";
    
    return $this->db->query($sql, array($university_id))->result();
  }

	//for favorites page - schools
	public function get_fave_items($user_id) {
	  $this->db->select('favorites.favorites_id, university.university_id, university.university_name, university.university_slug, item.item_id, item.item_name, item.item_slug, category.category_name, category.category_slug, AVG( attributerating.attributerating_rating ) AS score');
    $this->db->from('favorites');
    $this->db->join('item', 'favorites.item_id = item.item_id', 'inner');
    $this->db->join('category', 'category.category_id = item.category_id', 'inner');
    $this->db->join('university', 'item.university_id = university.university_id', 'inner');
    $this->db->join('rating', 'item.item_id = rating.item_id', 'left');
    $this->db->join('attributerating', 'rating.rating_id = attributerating.rating_id', 'left');
    $this->db->where('favorites.users_id', $user_id);
    $this->db->group_by('item.item_name');
    $this->db->order_by('university.university_name');

    //$query = $this->db->get();
    //die($this->db->last_query());

    return $this->db->get()->result();
	}
	
	public function get_fave_schools($user_id) {
	  $this->db->select('favorites.favorites_id, university.university_id, university.university_name, university.university_slug, AVG( attributerating.attributerating_rating ) AS score');
    $this->db->from('favorites');
    $this->db->join('item', 'favorites.item_id = item.item_id', 'inner');
    $this->db->join('category', 'category.category_id = item.category_id', 'inner');
    $this->db->join('university', 'item.university_id = university.university_id', 'inner');
    $this->db->join('rating', 'item.item_id = rating.item_id', 'left');
    $this->db->join('attributerating', 'rating.rating_id = attributerating.rating_id', 'left');
    $this->db->where('favorites.users_id', $user_id);
    $this->db->group_by('item.item_name');
    $this->db->order_by('university.university_name');
    
    //$query = $this->db->get();
    //die($this->db->last_query());
    
    return $this->db->get()->result();
    
	}

  public function toggle_favorite($user_id, $item_id) {
    $data = array('users_id' => $user_id, 'item_id' => $item_id);
    $this->db->select('favorites.favorites_id, count(favorites.favorites_id) as total');
    $this->db->from('favorites');
    $this->db->where('favorites.users_id', $user_id);
    $this->db->where('favorites.item_id', $item_id);
    $result = $this->db->get()->row();
    if($result->total > 0) {
      if($this->db->delete('favorites', array('favorites_id' => $result->favorites_id)))
        return 'deleted';
      else
        return '';
    }
    else {
      if($this->db->insert('favorites', $data))
        return 'added';
      else
        return '';
    }
  }

  public function is_favorite($user_id, $item_id) {
    $this->db->select('favorites.favorites_id, count(favorites.favorites_id) as total');
    $this->db->from('favorites');
    $this->db->where('favorites.users_id', $user_id);
    $this->db->where('favorites.item_id', $item_id);
    $result = $this->db->get()->row();
    if($result->total > 0)
      return true;
    else
      return false;
  }
  
  public function add_photo($photo_data) {
    if($this->db->insert('photos', $photo_data))
      return 'added';
    else
      return '';
  }
}
