<h1><?= $title; ?></h1>

<?php if ($success) : ?>
    <div class="alert alert-success">L'article a été modifié avec succès !</div>
<?php endif; ?>

<form method="post">
    <?= $this->form->fields('input', 'title', 'Titre'); ?>
    <?= $this->form->fields('textArea', 'content', 'Article', ['rows' => '10']); ?>

    <?= $this->form->fields('select', 'category_id', 'Catégories', ['selects' => $categories, 'categoryId' => $post->category_id]); ?>

    <?= $this->form->submit('Valider'); ?>
</form>