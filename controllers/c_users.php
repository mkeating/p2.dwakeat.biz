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

		#create encrypted token via email and a random string
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

		#Insert into the db
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);

		# send confirmation email
		$to = Array("name" => "User", "email" => $_POST['email']);
		$from = Array("name" => APP_NAME,"email" => APP_EMAIL);
		$subject = 'Welcome to Salvo';
		$body = "Thanks for registering for Salvo: the world's smallest microblog.";

		$email = Email::send($to, $from, $subject, $body, true);

		# log in the new user

		setcookie("token", $_POST['token'], strtotime('+2 weeks'), '/');

		# redirect to 'Find People'
		Router::redirect('/posts/users');
		
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

			#store token in a cookie
			setcookie("token", $token, strtotime('+2 weeks'), '/');
		

			#send to main page
			Router::redirect("/posts/index");
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

	#for logged in user to edit profile
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

	public function p_profile(){

		#if user is blank, they're not logged in; redirect to login page
		if(!$this->user){
			Router::redirect('/users/login');
		}

		#if not redirected, continue:

		# Create the data array we'll use with the update method
		$data = Array("location" => $_POST['location'],
						"bio" => $_POST['bio']);

		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$this->user->user_id."'");

		#send to main page
		Router::redirect("/posts/index");

	}

	# to view public profile of any user
	public function see_profile($user_id){

		# get this user's data
		$q = "SELECT 
				users.first_name,
				users.last_name,
				users.location,
				users.bio
			FROM users 
			WHERE user_id=".$user_id;

		$data = DB::instance(DB_NAME)->select_row($q);

		# setup view
		$view = View::instance('v_users_see_profile');
		$view->user_name = $data['first_name'];
		$view->bio = $data['bio'];
		$view->location = $data['location'];

		//$this->template->content = View::instance('v_users_see_profile');

		# set title in template
		//$this->template->title = "Profile of ".$data['first_name'];

		# render view
		echo $view;

	}
}# end of user_controller class

?>
