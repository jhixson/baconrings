<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Main extends MY_Controller {
 
 
 
 
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');

        $this->load->model('campus_model');
    }
 
 
 
 
    function index(){
        // Try to get the user's id on Facebook
      $userId = $this->facebook->getUser();
      //var_dump($userId);
      //die();
 
        // If user is not yet authenticated, the id will be zero
        if($userId == 0){
            // Generate a login url
            $this->data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
        } else {
          $this->data['user'] = $userId;
          $query = $this->db->get_where('users', array('facebook_id' => $userId));
          if( count($query->result()) == 0 ) {
            // Get user's data and print it
            $profile = $this->facebook->api('/me');
            $this->data['user_profile'] = $profile;

            $user_data = array(
              'facebook_id' => $userId,
              'facebook_token' => $_GET['code']
            );

            //$this->ion_auth->update($user->id, $data);
            $new_id = $this->ion_auth->register($profile['username'], '', $profile['email'], $user_data);
            $this->session->set_userdata('messages', array(array('type' => 'message', 'content' => 'Successfully logged in.')));
          } else {
            $profile['email'] = $query->row()->email;
            $new_id = $query->row()->id;
            $this->session->set_userdata('messages', array(array('type' => 'error', 'content' => 'That Facebook account is already associated with an account. Logout and log in via Facebook to access it.')));
          }


          $session_data = array(
                'identity' => 'email',
                'email' => $profile['email'],
                'id'                   => $new_id, //kept for backwards compatibility
                'user_id'              => $new_id, //everyone likes to overwrite id so we'll use user_id
            );

            $this->session->set_userdata($session_data);
        }
            $this->load->view('main/index', $this->data);
    }
}

?>
