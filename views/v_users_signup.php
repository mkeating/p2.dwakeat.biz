<form method='POST' action='/users/p_signup' role="form">
	<div class="form_group">
		<label for="first_name">First Name</label>
		<input type='text' name='first_name' class="form-control" placeholder="First name">

	</div>
	<div class="form_group">
		<label for="last_name">Last Name</label>
		<input type='text' name='last_name' class="form-control" placeholder="Last name">
	</div>
	<div class="form_group">
		<label for="email">Email</label>
		<input type='text' name='email' class="form-control" placeholder="Email">

	</div>
	<div class="form_group">
		<label for="password">Password</label>
		<input type='password' name='password' class="form-control" placeholder="Password">
	</div>
	<?php if(isset($error) && $error == 'empty-fields'): ?>
		<div class='error'>
			All fields are required.
		</div>
	<?php endif; ?>
	<?php if(isset($error) && $error == 'duplicate'): ?>
		<div class='error'>
			Email in use. 
		</div>
	<?php endif; ?>
	<br><br>
		<button type='submit' class="btn btn-default">Submit</button>
</form>