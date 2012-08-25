<?php

class Ajax extends CI_Controller {
  
  function __construct()
	{
	  parent::__construct();
		$this->load->library('ion_auth');
    $this->load->library('session');
		$this->load->model('campus_model');
  }

  public function toggle_favorite($item_id) {
	  $result = array('status' => '', 'message' => '', 'data' => array());
		if ($this->ion_auth->logged_in()) {
      $user = $this->ion_auth->user()->row();
      $fav_result = $this->campus_model->toggle_favorite($user->id, $item_id);
      if(!empty($fav_result)) {
        $result['status'] = 'ok';
        $result['message'] = $fav_result;
      }
      else {
        $result['status'] = 'err';
        $result['message'] = 'Error updating favorite.';
      }
    }
    else {
      $result['status'] = 'err';
      $result['message'] = 'User not logged in.';
    }
    $this->data['result'] = json_encode($result);
  	$this->load->view('ajax/result', $this->data);
  }
}
