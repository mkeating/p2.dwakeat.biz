<?php

class posts_controller extends base_controller{

	public function __construct(){
		parent::__construct();

		#confirms user logged in
		if(!$this->user){
			die("Members only. <a href='/users/login'>Login</a>");

		}
	}

	public function add(){

		# setup view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title = "New Post";

		# render template
		echo $this->template;
	}

	public function p_add(){

		# associate this post with this user
		$_POST['user_id'] =  $this->user->user_id;

		# UNIX timestamp of when this post was created/modified
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();

		# insert
		DB::instance(DB_NAME)->insert('posts', $_POST);

		# feedback
		echo " post added.  <a href='/posts/add'>add another</a>";
	}

	public function index(){

		# set up the view
		$this->template->content = View::instance('v_posts_index');
		$this->template->title = "Posts";

		# build the query
		$q = "SELECT
				posts .*,
				users.first_name,
				users.last_name
			FROM posts
			INNER JOIN users 
				ON posts.user_id = users.user_id";

		# run the query
		$posts = DB::instance(DB_NAME)->select_rows($q);

		# pass data to the view
		$this->template->content->posts = $posts;

		# Render the view
		echo $this->template;
	}

	public function users(){

		# setup view
		$this->template->content = View::instance("v_posts_users");
		$this->template->title = "Users";

		# query for getting all users
		$q = "SELECT *
				FROM users";

		# execute query and store results in $users
		$users = DB::instance(DB_NAME)->select_rows($q);

		# query for getting who this user is currently following
		$q = "SELECT *
				FROM users_users
				WHERE user_id = ".$this->user->user_id;

		# execute query (select_array method returns results in array with 'users_id_followed as index')
		$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

		# pass data to view
		$this->template->content->users = $users;
		$this->template->content->connections = $connections;
	
		# render view
		echo $this->template;
	}

	public function follow($user_id_followed){

		# prepare the array to be inserted
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user-user_id,
			"user_id_followed" => $user_id_followed
			);

		# insert
		DB::instance(DB_NAME)->insert('users_users', $data);

		# send them back
		Router::redirect("/posts/users");

	}

	public function unfollow($user_id_followed){

		# Delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);

		# send back
		Router::redirect("/posts/users");
		
	}
}

?>