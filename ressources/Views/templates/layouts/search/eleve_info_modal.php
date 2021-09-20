<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>

<!-- Modal -->
<div class="modal  animated zoomIn  text-left" id="_eleve_modal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #f5a663;">
                <h4 class="modal-title" id="myModalLabel17">Informations générales de l'élève</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

                    <div class="row">
                        <label for="photo" style="  display: block; margin-left: auto; margin-right: auto;">
                            <figure>
                                <img title="photo du eleve" id="_recap-photo" width="200px" height="200px" src="<?= URL::upload() ?>img/eleve/no-photo.jpg" alt="" class="photo" class="center">
                            </figure>
                        </label>
                    </div>

                    <span id="_recap-id" style="display: none;"></span>

                    <div class="col-12">
                        <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                            <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">
                                <!-- ETAPE 01 -->
                                <div id="heading-etape-01" role="tab" class="card-header border-bottom-black border-bottom-warning">
                                    <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-01" aria-expanded="false" aria-controls="accordion-etape-01" class="text-uppercase black collapsed"><strong>Infomations personnelles sur l'élève</strong></a>
                                </div>

                                <div id="accordion-etape-01" role="tabpanel" aria-labelledby="heading-etape-01" class="collapse" aria-expanded="true" style="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Nom :</strong>

                                                    <em id="_recap-nom_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Prénom :</strong>

                                                    <em id="_recap-prenom_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Lieu de naissance :</strong>

                                                    <em id="_recap-lieu_naissance_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Date de naissance:</strong>

                                                    <em id="_recap-date_naissance_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Sexe :</strong>

                                                    <em id="_recap-sexe_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Pays :</strong>

                                                    <em id="_recap-pays_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <!--  <div class="row mt-1">-->
                                        <!-- <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Classe :</strong>

                                        <em  id="_recap-classe_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                    </div>
                                </div> -->

                                        <!-- <div class="col-2">

                                </div> -->

                                        <!-- <div class="col-5">-->
                                        <!-- <div class="row">
                                        <strong class="col-6">Statut de l'élève :</strong>

                                        <em  id="_recap-statut_eleve" class="col-6"><?= Helpers::repeatChar(); ?> </em>
                                    </div> -->
                                        <!-- </div>
                            </div> -->

                                        <br>

                                        <div class="row mt-1">

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Classe de l'an dernier :</strong>

                                                    <em id="_recap-classe" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <!-- <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Salle de Classe :</strong>

                                        <em  id="_recap-salle_classe_eleve" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                    </div>
                                    </div> -->

                                            <div class="col-2">

                                            </div>


                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Prénom d'usage :</strong>

                                                    <em id="_recap-prenom_usage" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Nom de l'ancienne école :</strong>

                                                    <em id="_recap-ecole" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">

                                            </div>
                                        </div>




                                    </div>
                                </div>

                                <!-- ETAPE 02 -->
                                <div id="heading-etape-02" role="tab" class="card-header border-bottom-black border-bottom-warning">
                                    <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-02" aria-expanded="false" aria-controls="accordion-etape-02" class="text-uppercase black collapsed"><strong>Dossier parental </strong></a>
                                </div>

                                <div id="accordion-etape-02" role="tabpanel" aria-labelledby="heading-etape-02" class="collapse" aria-expanded="true" style="">
                                    <div class="card-body">


                                        <!-- _recap père -->
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

                                                    <em id="_recap-nom_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Prénom du père :</strong>

                                                    <em id="_recap-prenom_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Quartier du père:</strong>

                                                    <em id="_recap-quartier_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Employeur du père:</strong>

                                                    <em id="_recap-employeur_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Profession du père:</strong>

                                                    <em id="_recap-profession_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">BP du père:</strong>

                                                    <em id="_recap-lieu_travail_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Téléphone du père:</strong>

                                                    <em id="_recap-telephone_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Bureau du père :</strong>

                                                    <em id="_recap-bureau_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Adresse email du père:</strong>

                                                    <em id="_recap-email_pere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>



                                        </div>


                                        <!-- _recap mère -->

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

                                                    <em id="_recap-nom_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Prénom de la mère:</strong>

                                                    <em id="_recap-prenom_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Quartier de la mère :</strong>

                                                    <em id="_recap-quartier_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                            <div class="col-2">

                                            </div>
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Employeur de la mère:</strong>

                                                    <em id="_recap-employeur_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-5">

                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Profession de la mère:</strong>

                                                    <em id="_recap-profession_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">BP de la mère:</strong>

                                                    <em id="_recap-lieu_travail_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Téléphone de la mère :</strong>

                                                    <em id="_recap-telephone_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Bureau la de mère:</strong>

                                                    <em id="_recap-bureau_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Adresse email de la mère :</strong>

                                                    <em id="_recap-email_mere" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>



                                        </div>
                                        <br>
                                        <div class="row">
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

                                                    <em id="_recap-nom_personne_urgence" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Prénom de la personne à contacter en cas d'urgence:</strong>

                                                    <em id="_recap-prenom_personne_urgence" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Téléphone de la personne à contacter en cas d'urgence :</strong>

                                                    <em id="_recap-telephone_personne_urgence" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Lien :</strong>

                                                    <em id="_recap-lien" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                                <!-- ETAPE 03 -->
                                <div id="heading-etape-04" role="tab" class="card-header border-bottom-black border-bottom-warning">
                                    <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-04" aria-expanded="false" aria-controls="accordion-etape-04" class="text-uppercase black collapsed"><strong>Dossier médical</strong></a>
                                </div>

                                <div id="accordion-etape-04" role="tabpanel" aria-labelledby="heading-etape-04" class="collapse" aria-expanded="false" style="">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-5">
                                                <div class="row">


                                                    <strong class="col-6">Allergies :</strong>

                                                    <em id="_recap-allergie" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Groupe sanguin:</strong>

                                                    <em id="_recap-groupe_sanguin" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Maladies récurrentes :</strong>

                                                    <em id="_recap-maladie_recurrente" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Nom du médecin :</strong>

                                                    <em id="_recap-nom_medecin" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Téléphone du médecin:</strong>

                                                    <em id="_recap-telephone_medecin" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Email du médecin :</strong>

                                                    <em id="_recap-email_medecin" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Problèmes particuliers:</strong>

                                                    <em id="_recap-probleme_particulier" class="col-6"><?= Helpers::repeatChar(); ?></em>
                                                </div>
                                            </div>

                                            <div class="col-2">

                                            </div>

                                            <div class="col-5">
                                                <div class="row">
                                                    <strong class="col-6">Autres informations :</strong>

                                                    <em id="_recap-autres" class="col-6"><?= Helpers::repeatChar(); ?> </em>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ETAPE 04 -->


                            </div>
                        </div>
                    </div>

                    <!-- <div class="row mt-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Fonction :</strong>

                                <em class="col-lg-6 col-sm-12"  id="_recap-fonciton" ><?= "" ?></em>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Salle de Classe :</strong>

                                <em class="col-lg-6 col-sm-12"  id="_recap-salle_classe" ><?= "" ?></em>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="row"> -->
                        <!-- <div class="col-lg-6 col-sm-12"> -->
                        <!-- <div class="row">
                                <strong class="col-lg-6 col-sm-12">Fonction :</strong>

                                <em class="col-lg-6 col-sm-12"  id="_recap-fonciton" ><?= "" ?></em>
                            </div>
                        </div> -->
<!-- 
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <a href="#" id="_recap-pieces_jointes" class="btn btn-social btn-min-width mb-1 mr-1"><span class="fa fa-download font-medium-4"></span> Télécharger piece jointe</a>
                            </div>
                        </div> -->
                        <!-- <input type="file" class="inputfile"  accept="image/*" style="display: none;" name="photo_autres" id="photo_autres" onchange="readURL(this, '.photo_autres');" />
                        <label for="photo_autres" style="  display: block; margin-left: auto; margin-right: auto;">
                            <figure>
                                <img title="cliquer pour modifier une piece jointe" width="200px" height="200px" src="<?= URL::base() ?>ressources/uploads/img/eleve/<?= "" ?>" alt="" class="photo_autres " >
                            </figure>
                        </label> -->
                    <!-- </div> -->

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
                <button type="button" onclick="_redirect_to()" class="btn btn-outline-secondary">Modifier</button>
            </div>
        </div>
    </div>
</div>