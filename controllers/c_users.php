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
		# displays signup 

		# setup view
			$this->template->content = View::instance('v_users_signup');
			$this->template->title = "Sign Up";
		# render
			echo $this->template;
	}

	public function p_signup(){

		#adding data to the user
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();

		#encrypt password
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		#creat encrypted token via email and a random string
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

		#Insert into the db
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);

		# temp confirm
		Router::redirect("/users/profile");
		
	}

	public function login($error = NULL){
		# Setup view 
			$this->template->content = View::instance('v_users_login');
			$this->template->title = "Login";

		# Pass data to the view
			$this->template->content->error = $error;

		# render template
			echo $this->template;
	}

	public function p_login(){

		#sanitize
		$_POST = DB::instance('p2_dwakeat_biz')->sanitize($_POST);

		#hash submitted password
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		#search DB for this email and hash, returns token if available
		$q = "SELECT token
			FROM users
			WHERE email = '".$_POST['email']."'
			AND password = '".$_POST['password']."'";

		$token = DB::instance(DB_NAME)->select_field($q);

		#if no match:
		if(!$token){

			#send back to login page
			Router::redirect("/users/login/error");
		}
		#found match
		 else {

			/*store token in a cookie
			 nothing else can echo to the page before setcookie is called
			 Not even one single white space.
        param 1 = name of the cookie
        param 2 = the value of the cookie
        param 3 = when to expire
        param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
		*/
			setcookie("token", $token, strtotime('+2 weeks'), '/');
		

			#send to main page
			Router::redirect("/");
		}

	}

	public function logout(){
		
		# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
		
		# Create the data array we'll use with the update method
		$data = Array("token" => $new_token);

		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");
		
		# Delete their token cookie by setting it to a date in the past - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');

		#send back to main index
		Router::redirect("/");
	}

	
	public function profile(){

		#if user is blank, they're not logged in; redirect to login page
		if(!$this->user){
			Router::redirect('/users/login');
		}

		#if not redirected, continue:

		# setup view
		$this->template->content = View::instance('v_users_profile');

		# set title in template
		$this->template->title = "Profile of ".$this->user->first_name;

		# render view
		echo $this->template;
	}
}# end of user_controller class

?>
