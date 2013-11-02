<?php foreach($users as $user): ?>

	<!-- Print this user's name -->
	<?=$user['first_name']?> <?=$user['last_name']?>

	<!-- IF there exists a connection -->
	<?php if(isset($connections[$user['user_id']])): ?>
		<a href="/posts/unfollow/<?=$user['user_id']?>">Unfollow</a>

	<!-- otherwise, show the follow link -->
	<?php else: ?>
		<a href='/posts/follow/<?=$user["user_id"]?>'>Follow</a>
		<?php endif; ?>

	<br><br>
<?php endforeach; ?>