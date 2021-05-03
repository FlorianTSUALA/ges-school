<h1><?= $postsByCategory[0]->category; ?></h1>

<div class="row">
	<ul class="col-sm-8">
		<?php foreach($postsByCategory as $post): ?>

			<h2><?= $post->title; ?></h2>

			<p><em><?= $post->category; ?></em></p>

			<p><?= $post->extract; ?></p>

			<p><a href="<?= $post->url; ?>">Voir la suite</a></p>

		<?php endforeach; ?>
	</ul>

	<ul class="col-sm-4">
		<?php
		foreach($allCategories as $category):
		?>
		<li><a href="<?= $category->url; ?>"><?= $category->name; ?></a></li>
		<?php
		endforeach;
		?>
	</ul>
</div>