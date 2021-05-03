<?php

use App\Helpers\Helpers;
use Core\Routing\URL;

?>
<!-- Step 4 -->
<h6><strong>Recapitulatif</strong></h6>
<fieldset>
    <div class="row">
        <div class="col-md-12">
            <h4 class="form-section text-warning" align="center">
                <strong>Vérification des informations saisies</strong>
            </h4>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">
                    <!-- ETAPE 01 -->
                    <div id="heading-etape-01" role="tab" class="card-header border-bottom-blue border-bottom-warning">
                        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-01" aria-expanded="false" aria-controls="accordion-etape-01" class="text-uppercase blue collapsed"><strong>Infomations personnelles sur l'élève</strong></a>
                    </div>

                    <div id="accordion-etape-01" role="tabpanel" aria-labelledby="heading-etape-01" class="collapse" aria-expanded="true" style="">
                        <div class="card-body">
                            <div class="row">
                                <label for="photo_eleve" style="  display: block; margin-left: auto; margin-right: auto;">
                                    <figure>
                                        <img width="200px" height="200px"  src="<?= URL::base() ?>assets/app-assets/images/portrait/small/no-photo.jpg" alt="" class="photo" class="center">
                                    </figure>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom :</strong>

                                        <em  id="recap-nom_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Prénom :</strong>

                                        <em  id="recap-prenom_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Lieu de naissance :</strong>

                                        <em  id="recap-lieu_naissance_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Date de naissance:</strong>

                                        <em  id="recap-date_naissance_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Sexe :</strong>

                                        <em  id="recap-sexe_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Pays :</strong>

                                        <em  id="recap-pays_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Classe :</strong>

                                        <em  id="recap-classe_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Statut de l'élève :</strong>

                                        <em  id="recap-statut_apprenant_eleve" class="col-6"><?= Helpers::repeatChar();?> </em>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Salle de Classe :</strong>

                                        <em  id="recap-salle_classe_eleve" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Année Scolaire :</strong>

                                        <em  id="recap-annee_scolaire" class="col-6"><?= Helpers::repeatChar();?> </em>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom de l'ancienne école  :</strong>

                                        <em  id="recap-ecole" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Classe de l'an dernier :</strong>

                                        <em  id="recap-classe" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Contact de l'école :</strong>

                                        <em  id="recap-telephone" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Prénom d'usage :</strong>

                                        <em  id="recap-prenom_usage" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                    <!-- ETAPE 02 -->
                    <div id="heading-etape-02" role="tab" class="card-header border-bottom-blue border-bottom-warning">
                        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-02" aria-expanded="false" aria-controls="accordion-etape-02" class="text-uppercase blue collapsed"><strong>Dossier parental </strong></a>
                    </div>

                    <div id="accordion-etape-02" role="tabpanel" aria-labelledby="heading-etape-02" class="collapse" aria-expanded="true" style="">
                        <div class="card-body">


                            <!-- recap père -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="" align="center">
                                        <strong>Dossier du père ou tuteur</strong><br><br><br>

                                    </h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom du père :</strong>

                                        <em  id="recap-nom_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Prénom du père :</strong>

                                        <em  id="recap-prenom_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Pays du père:</strong>

                                        <em  id="recap-pays_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Employeur du père:</strong>

                                        <em  id="recap-employeur_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Profession du père:</strong>

                                        <em  id="recap-profession_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">BP du père:</strong>

                                        <em  id="recap-lieu_travail_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>



                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Téléphone du père:</strong>

                                        <em  id="recap-telephone_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Bureau du père :</strong>

                                        <em  id="recap-bureau_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Adresse email du père:</strong>

                                        <em  id="recap-email_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Quartier du père:</strong>

                                        <em  id="recap-quartier_pere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                            </div>


                            <!-- recap mère -->

                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="" align="center">
                                        <strong>Dossier de la mère ou tutrice</strong><br><br><br>

                                    </h4>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom de la mère :</strong>

                                        <em  id="recap-nom_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Prénom de la mère:</strong>

                                        <em  id="recap-prenom_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Pays de la mère :</strong>

                                        <em  id="recap-pays_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                                <div class="col-2">

                                </div>
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Employeur de la mère:</strong>

                                        <em  id="recap-employeur_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>


                            <div class="col-5">

                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Profession de la mère:</strong>

                                        <em  id="recap-profession_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">BP de la mère:</strong>

                                        <em  id="recap-lieu_travail_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Téléphone de la mère :</strong>

                                        <em  id="recap-telephone_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Bureau la de mère:</strong>

                                        <em  id="recap-bureau_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Adresse email de la mère :</strong>

                                        <em  id="recap-email_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Quartier de la mère :</strong>

                                        <em  id="recap-quartier_mere" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                            </div>
                            <br> <div class="row">
                                <div class="col-md-12">
                                    <h4 class="" align="center">
                                        <br> <strong>Personne à contacter en cas d'urgence</strong><br>

                                    </h4>
                                </div>
                            </div><br>

                            <!-- personne à contacter en cas d'urgence -->

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom de la personne à contacter en cas d'urgence:</strong>

                                        <em  id="recap-nom_personne_urgence" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Prénom de la personne à contacter en cas d'urgence:</strong>

                                        <em  id="recap-prenom_personne_urgence" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Téléphone de la personne à contacter en cas d'urgence :</strong>

                                        <em  id="recap-telephone_personne_urgence" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Lien :</strong>

                                        <em  id="recap-lien" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div> 
                            </div>

                        </div>
                    </div>




                    <!-- ETAPE 03 -->
                    <div id="heading-etape-04" role="tab" class="card-header border-bottom-blue border-bottom-warning">
                        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-04" aria-expanded="false" aria-controls="accordion-etape-04" class="text-uppercase blue collapsed"><strong>Dossier médical</strong></a>
                    </div>

                    <div id="accordion-etape-04" role="tabpanel" aria-labelledby="heading-etape-04" class="collapse" aria-expanded="false" style="">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-5">
                                    <div class="row">


                                        <strong class="col-6">Allergies :</strong>

                                        <em  id="recap-allergie" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Groupe sanguin:</strong>

                                        <em  id="recap-groupe_sanguin" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Maladies récurrentes :</strong>

                                        <em  id="recap-maladie_recurrente" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom du médecin :</strong>

                                        <em  id="recap-nom_medecin" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Téléphone du médecin:</strong>

                                        <em  id="recap-telephone_medecin" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Email du médecin :</strong>

                                        <em  id="recap-email_medecin" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Problèmes particuliers:</strong>

                                        <em  id="recap-probleme_particulier" class="col-6"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Autres informations :</strong>

                                        <em  id="recap-autres" class="col-6"><?= Helpers::repeatChar();?> </em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ETAPE 04 -->


                </div>
            </div>
        </div>
    </div>
</fieldset>