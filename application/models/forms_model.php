<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	// input stuff
	public function input_stuff($table, $data) {
  		$this->db->insert($table, $data);
	}
	
	
}