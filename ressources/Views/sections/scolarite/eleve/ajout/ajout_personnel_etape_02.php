<?php


use Core\Routing\URL;
use App\Helpers\Helpers;

?>

<!-- Step 2 -->
<h6><strong>Recapitulatif Informations</strong></h6>
<fieldset>
    <div class="row">
        <div class="col-md-12">
            <h4 class="form-section text-warning" align="">
                <strong>Vérification des informations saisies</strong>
            </h4>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card  collapse-icon accordion-icon-rotate panel mb-0 box-shadow-0 border-0">
                    <!-- ETAPE 02 -->
                    <div id="heading-etape-01" role="tab" class="card-header border-bottom-blue border-bottom-warning">
                        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-01" aria-expanded="true" aria-controls="accordion-etape-01" class="text-uppercase blue collapsed"><strong>Infomations générales</strong></a>
                    </div>

                    <div id="accordion-etape-01" role="tabpanel" aria-labelledby="heading-etape-01" class="collapse show" aria-expanded="true" >
                        <div class="card-body">

                            <div class="row">
                                <!-- <input type="file" class="inputfile" style="display: none;"  accept="image/*" name="photo" id="photo" onchange="readURL(this, '.photo');" /> -->
                                <label for="photo" style="  display: block; margin-left: auto; margin-right: auto;">
                                    <figure>
                                        <img title="cliquer pour ajouter une photo" width="200px" height="200px"  src="<?= URL::base() ?>assets/app-assets/images/portrait/small/no-photo.jpg" alt="" class="photo" class="center">
                                    </figure>
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom :</strong>

                                        <em id="recap-nom" class="col-6">MAVOUGOU MBA OBIANG</em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Prénom :</strong>

                                        <em id="recap-prenom" class="col-6">Albert Steve François</em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Téléphone :</strong>

                                        <em class="col-6" id="recap-telephone">Masculin</em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Email  :</strong>

                                        <em class="col-6" id="recap-email">23 Septembre 2013</em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Date de prise de service :</strong>

                                        <em class="col-6" id="recap-date_prise_service" ></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Adresse :</strong>

                                        <em class="col-6" id="recap-adresse" ></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Pays :</strong>

                                        <em class="col-6"  id="recap-pays" ></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Type de personnel :</strong>

                                        <em class="col-6"  id="recap-type_personnel" ></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Login :</strong>

                                        <em class="col-6"  id="recap-login" ></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Sexe :</strong>

                                        <em class="col-6"  id="recap-sexe" ></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Assurance :</strong>

                                        <em class="col-6"  id="recap-assurance" ></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Autres :</strong>

                                        <em class="col-6"  id="recap-autres" ></em>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Fonction du personnel :</strong>

                                        <em class="col-6"  id="recap-fonction" ></em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <!-- <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Autres :</strong>

                                        <em class="col-6"  id="recap-autres" ></em>
                                    </div>
                                </div> -->
                            </div>

                        <div class="row">
                            <!-- <input type="file" class="inputfile"  accept="image/*" style="display: none;" name="photo_autres" id="photo_autres" onchange="readURL(this, '.photo_autres');" /> -->
                            <label for="photo_autres" style="  display: block; margin-left: auto; margin-right: auto;">
                                <figure>
                                    <img title="cliquer pour ajouter une piece jointe" width="200px" height="200px"  src="<?= URL::base() ?>assets/app-assets/images/portrait/small/attachement.jpg" alt="" class="photo_autres " >
                                </figure>
                            </label>
                        </div>

                    </div>

                    
                  
                    

                    <!-- ETAPE 03
                    <div id="heading-etape-03" role="tab" class="card-header border-bottom-blue border-bottom-warning">
                        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-03" aria-expanded="false" aria-controls="accordion-etape-03" class="text-uppercase blue collapsed"><strong>Dossier parental (Maternelle)</strong></a>
                    </div>

                    <div id="accordion-etape-03" role="tabpanel" aria-labelledby="heading-etape-03" class="collapse" aria-expanded="true" style="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Nom du mère :</strong>

                                        <em class="col-6">PADONOU</em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Prénom du mère :</strong>

                                        <em class="col-6">Pauline Reine</em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Profession :</strong>

                                        <em class="col-6">Magistrat</em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Employeur du mère :</strong>

                                        <em class="col-6 danger"><?= Helpers::repeatChar();?></em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Lieu de travail du mère :</strong>

                                        <em class="col-6">Palais de Justice</em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Téléphone du mère :</strong>

                                        <em class="col-6">(+241) 66 89 03 33</em>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Ville de résidence du mère :</strong>

                                        <em class="col-6">Libreville</em>
                                    </div>
                                </div>

                                <div class="col-2">

                                </div>

                                <div class="col-5">
                                    <div class="row">
                                        <strong class="col-6">Adresse email du mère :</strong>

                                        <em class="col-6">padonou@gmail.com</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</fieldset>