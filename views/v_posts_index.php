<?php foreach($posts as $post): ?>

		<div class="post">
			<div class='post_header'>
				<p class="name"><?=$post['first_name']?> <?=$post['last_name']?> posted:</p>
			</div>
			<div class='post_content'>
				<h1><?=$post['content']?></h1>
			</div>
			<div class='post_footer'>
				<time datetime="<?=Time::display($post['created'], 'Y-m-d G:i')?>">
						<?=Time::display($post['created'])?>
				</time>
			</div>

	</div>
	
<?php endforeach; ?>