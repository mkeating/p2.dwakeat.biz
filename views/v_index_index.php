<!-- For logged in users -->
		<?php if($user): ?>
			<!-- nav -->
			<div class="row">
				<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
							<span class="sr-only">Toggle Navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse" id="collapse">
						<!--<div class="home pull-left">
							<a href="index.html">Arrive</a>
						</div>-->
						<ul class="nav navbar-nav pull-right">
							<li><a href='/'>Home</a></li>
							<li><a href='/users/logout'>Logout</a></li>
							<li><a href='/users/profile'>Profile</a></li>
							<li><a href='/posts/add'>New Post</a></li>
							<li><a href='/posts/users'>Find People</a></li>

						</ul>
					</div>
				</nav>
			</div>
			<!-- end of nav -->

	<!-- For non-logged in users -->
		<?php else: ?>
			<div class="jumbotron">
					<div class="container">
						<div class="title">
							<h1> Salvo </h1>
							<p>A microblog for CSCI E-15</p>
							<p><a class="btn btn-primary btn-lg" href="/users/signup">Sign Up</a> or <a href="/users/login">Login</a></p>
							<p>Features: Login-on-Sign-up</p>
						</div>
					</div>
			</div>
		<?php endif; ?>