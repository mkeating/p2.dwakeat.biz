<form method='POST' action='/users/p_login' role='form'>
	<div class='form-group'>
		<label for='email'>Email</label>
		<input type='text' name='email' placeholder='Email'>
	</div>
	<div class='form-group'>
		<label for='password'>Password</label>
		<input type='password' name='password' placeholder='Password'>
	</div>
	<?php if(isset($error)): ?>
		<div class='error'>
			Login failed. Double check your email and password.
		</div>
		<br>
	<?php endif; ?>

	<button type='submit' class='btn btn-default'>Login</button>
</form>