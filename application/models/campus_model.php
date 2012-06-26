<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campus_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	// Retrieve a list without markup
	public function get_campuses($table, $where = array()) {
	
		return $this->db->get_where($table, $where)->result();
	
	}
}