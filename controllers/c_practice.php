<?php

	#sql stuff
	class practice_controller extends base_controller {

		public function add(){
			$q = "INSERT INTO users SET
				first_name = 'Sam',
				last_name = 'Seaborn',
				email = 'seaborn@whitehouse.gov'";

			#Runs the command
			echo DB::instance('p2_dwakeat_biz')->query($q);
	}

		public function update(){
			$q = "UPDATE users
				SET email = 'samseaborn@whitehouse.gov'
				WHERE email = 'seaborn@whitehouse.gov'";

			echo DB::instance('p2_dwakeat_biz')->query($q);		
	}

		public function delete(){
			$q = "DELETE FROM users
				WHERE email = 'samseaborn@whitehouse.gov'";

			echo DB::instance('p2_dwakeat_biz')->query($q);
		}
}
?>
