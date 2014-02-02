<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook {

	function __construct() {

	}
	
	public function connect() {
	
		$CI =& get_instance();

		$CI->config->load('facebook');
		
		$app_id = $CI->config->item('appId');
		$app_secret = $CI->config->item('secret');
		$my_url = current_url();
	
		session_start();
		if(isset($_GET['code'])) { $code = $_GET["code"]; }
	
		if(empty($code)) {
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
				. $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
				. $_SESSION['state'];
		
			echo("<script> top.location.href='" . $dialog_url . "'</script>");
		}
		
		if($_GET['state'] == $_SESSION['state']) {
			$token_url = "https://graph.facebook.com/oauth/access_token?"
				. "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
				. "&client_secret=" . $app_secret . "&code=" . $code;
				
				var_dump($token_url);
  			die();
		
			$response = @file_get_contents($token_url);
			$params = null;
			parse_str($response, $params);
		
			$token = $params['access_token'];
			
			$graph_url = "https://graph.facebook.com/me?access_token=" 
				. $params['access_token'];
		
			$user = json_decode(file_get_contents($graph_url));
			
			return array(
				'user' => $user,
				'token' => $token
			);
			
		} else {
			echo("The state does not match. You may be a victim of CSRF.");
		}
		
	}
	
	
	public function is_authorized($id, $token) {

		if($token) {
			$graph_url = 'https://graph.facebook.com/me?access_token='.$token;
			$response = json_decode(file_get_contents($graph_url));
		} else { $response = ''; }
	
		if( ! empty($response) && ! isset($response->error) ) {
			return true;
		} else {
			return false;
		}

	}
	
	
	public function login($user, $token) {
	
		if( ! $user || ! $token ) { return false; }
		
		$CI =& get_instance();
	
		// Test if a user already exists with this Facebook id
		$query = $CI->db->get_where( 'User', array( 'facebook_id' => $user->id ) )->result();
		if( count($query) != 0 ) {
			// If yes, log them in, and update the token while we're at it
			$CI->db->where('facebook_id', $user->id);
			$CI->db->update( 'User', array('facebook_token' => $token));
			
			if( $CI->ion_auth->fb_login($user->id) ) {
				redirect('auth');
			} else { return false; }
			
		} else {
			$username = ($user->username) ? $user->username : $user->id;
		
			$data = array(
				'username' => $username,
				'password' => '',
				'email' => '',
				'name' => $user->name,
				'ip_address' => ip2long($CI->input->ip_address()),
				'created_on' => time(),
				'active' => 1,
				'timezone' => 'UM5',
				'facebook_id' => $user->id,
				'facebook_token' => $token
			);
			if( $CI->db->insert( 'User', $data ) ) {
				if( $CI->ion_auth->fb_login($user->id) ) {
					$user_obj = $CI->ion_auth->user()->row();
					//$this->set_profile_picture($user_obj);
					redirect('auth');
				} else { return false; }
			} else { return false; }
		}
	
	}
	
	
	public function set_profile_picture($user) {
	
		$CI =& get_instance();
		$CI->load->library('images');
	
		$pic_url = 'https://graph.facebook.com/'.$user->facebook_id.'/picture?type=large';
		srand();
		$filename = md5(uniqid(mt_rand())) . '.jpg';
		$newfile = './uploads/'.$filename;
		file_put_contents($newfile, file_get_contents($pic_url));
		if( ! $CI->images->squareThumb($newfile, $newfile, 120) ) { return false; };
		
		if( isset($user->image) ) {
			$file = './uploads/'.$user->image;
			if(file_exists($file)) { unlink($file); }
		}

		if( ! $CI->ion_auth->update($user->id, array('image' => $filename))) { return false; };
		
		return $filename;
	}
	
	
	public function get_friends($user) {

		$CI =& get_instance();

		if( $this->is_authorized($user->facebook_id, $user->facebook_token) ) {

			$graph_url = 'https://graph.facebook.com/'.$user->facebook_id.'/friends?access_token='.$user->facebook_token;

			$friends = json_decode(file_get_contents($graph_url))->data;
			$response = array();
			foreach($friends as $friend) {
				$user = $CI->db->get_where('User', array('facebook_id' => $friend->id))->row();
				if($user) {
					$response[] = $user->id;
				}
			}
	
			if( isset($response) ) { return $response; }
			else { return false; }
		
		} else { return false; }
	}

}