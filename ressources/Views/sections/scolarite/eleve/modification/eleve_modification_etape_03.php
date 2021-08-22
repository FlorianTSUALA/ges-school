<?php


?>
<!-- Step 3 -->
<h6><strong>Dossier médical</strong></h6>
<fieldset>
    <div class="row">
        <div class="col-md-12">
            <h4 class="form-section text-warning" align="center">
                <strong>Dossier médical</strong>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="groupe_sanguin" class="col-4 col-form-label">Groupe sanguin:</label>
                <div class="col-8">
                    <select id="groupe_sanguin" class="select2 js-example-programmatic form-control" name="groupe_sanguin" >
                        <option  <?= (($eleve->groupe_sanguin??"") == "Inconnu")?"selected":"" ?>  value="Inconnu">- Choissisez un groupe sanguin -</option>
                        <option  <?= (($eleve->groupe_sanguin??"") == "A")?"selected":"" ?> value="A">A</option>
                        <option  <?= (($eleve->groupe_sanguin??"") == "B")?"selected":"" ?> value="B">B</option>
                        <option  <?= (($eleve->groupe_sanguin??"") == "O")?"selected":"" ?> value="O">O</option>
                        <option  <?= (($eleve->groupe_sanguin??"") == "AB")?"selected":"" ?> value="AB">AB</option>
                    </select>
                </div>
            </div>

            <div class="valid-feedback">Valider.</div>
            <div class="invalid-feedback">
                Veuillez remplir ce champ.
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label for="nom_medecin" class="col-4 col-form-label">Nom du médecin :</label>
                <div class="col-8">
                    <input placeholder="Nom du médecin traitant" type="text" class="form-control" value="<?= $eleve->nom_medecin??"" ?>" id="nom_medecin" name="nom_medecin" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="telephone_medecin" class="col-4 col-form-label">Téléphone du médecin:</label>
                <div class="col-8">
                    <input placeholder="Numéro de téléphone du médecin traitant" type="text" class="form-control" value="<?= $eleve->telephone_medecin??"" ?>" id="telephone_medecin" name="telephone_medecin" />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label for="email_medecin" class="col-4 col-form-label">Email du médecin :</label>
                <div class="col-8">
                    <input placeholder="Adresse email du médecin traitant" type="email" class="form-control" value="<?= $eleve->email_medecin??"" ?>" id="email_medecin" name="email_medecin" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="allergie" class="col-4 col-form-label">Allergies :</label>
                <div class="col-8">
                    <textarea placeholder="Renseigner toutes les allergies de l'élève" class="form-control" style="min-height: 100px; max-height: 100px;" id="allergie" name="allergie"><?= $eleve->allergie??"" ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label for="maladie_recurrente" class="col-4 col-form-label">Maladies récurrentes :</label>
                <div class="col-8">
                    <textarea placeholder="Renseigner toutes les maladies récurrentes de l'élève" class="form-control" style="min-height: 100px; max-height: 100px;" id="maladie_recurrente" name="maladie_recurrente"><?= $eleve->maladie_recurrente??"" ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="probleme_particulier" class="col-4 col-form-label">Problèmes particuliers:</label>
                <div class="col-8">
                    <textarea placeholder="Renseigner tous les problèmes particuliers de l'élève" class="form-control" style="min-height: 100px; max-height: 100px;" id="probleme_particulier" name="probleme_particulier"><?= $eleve->probleme_particulier??"" ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label for="autres" class="col-4 col-form-label">Autres informations :</label>
                <div class="col-8">
                    <textarea placeholder="Renseigner toutes autres informations sur l'élève" class="form-control" style="min-height: 100px; max-height: 100px;" id="autres" name="autres"><?= $eleve->autres??"" ?></textarea>
                </div>
            </div>
        </div>
    </div>
</fieldset>