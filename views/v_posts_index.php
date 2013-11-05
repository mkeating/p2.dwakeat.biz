<?php foreach($posts as $post): ?>
	<div class='row'>
		<div clas='col-lg-4 col-md-4 col-sm-0'></div>
		<div clas='col-lg-4 col-md-4 col-sm-12'>
		<div class="post">
			<div class='post_header'>
				<p><?=$post['first_name']?> <?=$post['last_name']?> posted:</p>
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
		</div>
		<div clas="col-lg-4 col-md-4 col-sm-0"></div>	
	</div>
	
	<?php endforeach; ?>