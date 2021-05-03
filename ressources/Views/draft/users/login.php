<?php if ($error) : ?>
    <div class="alert alert-danger">Identifiants incorrects</div>
<?php endif; ?>

<form method="post">
    <?=$this->form->input('pseudo');?>
    <?=$this->form->input('mdp', 'mot de passe', ['type' => 'password']);?>
    <?=$this->form->submit('Valider', 'btn btn-warning');?>
</form>