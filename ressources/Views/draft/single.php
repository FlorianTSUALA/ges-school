<h1><?= $post->title; ?></h1>
<p><em><a href="<?= $category->url; ?>"><?= $category->name; ?></a></em></p>

<p><?= $post->content; ?></p>

<?= ($post->date_modify != NULL) ? '<p><em>Modifié le ' . $post->date_modify . '</em></p>' : NULL ; ?>