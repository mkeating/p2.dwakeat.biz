<?php


class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		echo "users_controller construct called<br><br>";
	}

	public function index(){
		echo "This is the index page";
	}

	public function signup(){
		echo "this is the signup page";
	}

	public function login(){
		echo "this is the login page";
	}

	public function logout(){
		echo "this is the logout page";
	}
	
	public function profile($user_name == NULL){

		# Create a new View instance
		# Do not include .php with the view name
		#pass this view fragment to templates content
		this->template->content = View::instance('v_users_profile');

		# set title in template
		$this->template->title = "Profile";

		# pass info to the view fragment
		$this->template->content->user_name = $user_name;

		# render view
		echo $this-template;
	}
}# end of user_controller class

?>
