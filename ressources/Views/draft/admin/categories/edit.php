<h1><?= $title; ?></h1>

<?php if ($success) : ?>
    <div class="alert alert-success">La catégorie a été modifiée avec succès !</div>
<?php endif; ?>

<form method="post">
    <?= $this->form->fields('input', 'name', 'Nom de la catégorie'); ?>
    <?= $this->form->submit('Valider'); ?>
</form>