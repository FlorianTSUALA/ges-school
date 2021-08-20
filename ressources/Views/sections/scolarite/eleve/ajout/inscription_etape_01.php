<?php

use App\Model\Pays;
use App\Model\Classe;
use Core\Routing\URL;
use App\Helpers\Helpers;
use App\Model\SalleClasse;
use App\Model\AnneeScolaire;
use App\Model\StatutApprenant;

?>

<!-- Step 1 -->
<h6><strong>Identification de l'élève</strong></h6>
<fieldset>
    <div class="row">
        <div class="col-md-12">
            <h4 class="form-section text-warning" align="center">
                <strong>Identification de l'élève</strong>
            </h4>
        </div>
    </div>

    <div class="row">
        <input type="file" class="inputfile" style="display: none;" name="photo_eleve" id="photo_eleve" onchange="readURL(this, '.photo');"   accept="image/x-png,image/jpg,image/jpeg,image/gif,image/png,image/jfif" />
        <label for="photo_eleve" style="  display: block; margin-left: auto; margin-right: auto;">
            <figure>
                <img width="200px" height="200px"  src="<?= URL::base() ?>assets/app-assets/images/portrait/small/no-photo.jpg" alt="" class="photo" class="center">
            </figure>
        </label>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="nom_eleve" class="col-4 col-form-label">Nom<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <input placeholder="Nom de l'élève" type="text" class="form-control required" id="nom_eleve" name="nom_eleve" autofocus
                           required="required" />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label for="prenom_eleve" class="col-4 col-form-label">Prénom :</label>
                <div class="col-8">
                    <input placeholder="Prénom de l'élève" type="text" class="form-control" id="prenom_eleve" name="prenom_eleve" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="date_naissance_eleve" class="col-4 col-form-label">Date de naissance<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <input type="date" class="form-control required" id="date_naissance_eleve" name="date_naissance_eleve"
                           required="required" />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label for="lieu_naissance_eleve" class="col-4 col-form-label">Lieu de naissance<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <input placeholder="Lieu de naissance" type="text" class="form-control required" id="lieu_naissance_eleve" name="lieu_naissance_eleve"
                           required="required" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="pays_eleve" class="col-4 col-form-label">Pays d'origine<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <select id="pays_eleve" class="select2 form-control" name="pays_eleve" required>

                        <option value="" >- Choissisez une nationalité -</option>
                        <?php foreach($pays as $item){?>
                                <option value="<?= $item->{Pays::LIBELLE}; ?>"><?= $item->{Pays::LIBELLE}; ?></option>
                        <?php } ?>
                       
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-4">Sexe<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <div class="row">
                        <div class="col-5">
                            <label for="sexe_eleve-01" class="">Féminin</label>
                            <input name="sexe_eleve" id="sexe_eleve-01" type="radio" class="cke_button__radio_icon" value="F"
                                   required="required">
                        </div>

                        <div class="col-5">
                            <label for="sexe_eleve-02" class="">Masculin</label>
                            <input name="sexe_eleve" id="sexe_eleve-02" type="radio" class="cke_button__radio_icon" value="M">
                        </div>
                    </div>
                    <label id="sexe_eleve-error" class="error" for="sexe_eleve"></label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="prenom_usage" class="col-4 col-form-label">Prénom d'usage:</label>
                <div class="col-8">
                    <input placeholder="Prénom d'usage" type="text" class="form-control" id="prenom_usage" name="prenom_usage" />
                </div>
            </div>
        </div>
        


        <div class="col-md-6">
            <div class="form-group row">
                <label for="statut_apprenant_eleve" class="col-4 col-form-label">Statut de l'apprenant<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <select id="statut_apprenant_eleve" class="select2 form-control" name="statut_apprenant_eleve" required>

                        <option value="" >- Choissisez le statut actuel de l'élève -</option>
                        <?php foreach($statut_apprenants as $item){?>
                                <option value="<?= $item->{StatutApprenant::LIBELLE}; ?>"><?= $item->{StatutApprenant::LIBELLE}; ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label for="ecole" class="col-4 col-form-label">Nom de l'ancienne école:</label>
                <div class="col-8">
                    <input placeholder="Nom de l'ancienne école" type="text" class="form-control" id="ecole" name="ecole" />
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group row">
                <label for="classe" class="col-4 col-form-label">Classe de l'an dernier :</label>
                <div class="col-8">
                    <input placeholder="Classe fréquentée l'an dernier" type="text" class="form-control" id="classe" name="classe" />
                </div>
            </div>
        </div>



    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group row">
                <label for="classe_eleve" class="col-4 col-form-label">Classe<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <select id="classe_eleve" class="select2 form-control" name="classe_eleve" required>

                        <option value="" >- Choissisez la Classe de l'élève -</option>
                        <?php foreach($classes as $item){?>
                                <option value="<?= $item->{Classe::LIBELLE}; ?>"><?= $item->{Classe::LIBELLE}; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <label for="salle_classe_eleve" class="col-4 col-form-label"> Salle de Classe :</label>
                <div class="col-8">
                    <select id="salle_classe_eleve" class="select2 form-control" name="salle_classe_eleve" >

                        <option value="" >- Choissisez la salle de classe de l'élève -</option>
                        <?php foreach($salle_classes as $item){?>
                                <option value="<?= $item->{SalleClasse::LIBELLE}; ?>"><?= $item->{SalleClasse::LIBELLE}; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

    </div>

    
    <div class="row">

        <div class="col-md-6">
            <div class="form-group row">
                <label for="annee_scolaire" class="col-4 col-form-label">Année Scolaire<?= Helpers::required_input(); ?>:</label>
                <div class="col-8">
                    <select id="annee_scolaire" class="select2 form-control" name="annee_scolaire" required>

                        <option value="" >- Choissisez l'année Scolaire -</option>
                        <?php foreach($annee_scolaires as $item){?>
                                <option value="<?= $item->{AnneeScolaire::LIBELLE}; ?>"><?= $item->{AnneeScolaire::LIBELLE}; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

    </div>


</fieldset>

