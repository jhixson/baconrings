<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campus_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	// Get all campuses
	public function get_list($table, $where = array(), $limit = 100000, $offset = 0) {
	
		return $this->db->get_where($table, $where, $limit, $offset)->result();
	
	}
	
	// Get a single campus
	public function get_single($table, $where = array(), $limit = 1, $offset = 0) {
	
		return $this->db->get_where($table, $where, $limit, $offset)->row();
	
	}
	
}