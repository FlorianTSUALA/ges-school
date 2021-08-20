<?php

use Core\Routing\URL;

?>

<!-- Modal -->
<div class="modal  animated zoomIn  text-left" id="personnel_modal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Information générales du personnel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="card-body">

                    <div class="row">
                        <label for="photo" style="  display: block; margin-left: auto; margin-right: auto;">
                            <figure>
                                <img title="photo du personnel" id="recap-photo" width="200px" height="200px"  src="<?= URL::upload() ?>ressources/uploads/img/personnel/no-photo.jpg" alt="" class="photo" class="center">
                            </figure>
                        </label>
                    </div>

                    <span id="recap-id"  style="display: none;"></span>

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Nom :</strong>

                                <em id="recap-nom" class="col-lg-6 col-sm-12"><?= $personnel['nom']??"" ?></em>
                            </div>
                        </div>


                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Prénom :</strong>

                                <em id="recap-prenom" class="col-lg-6 col-sm-12"><?= $personnel['prenom']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Téléphone :</strong>

                                <em class="col-lg-6 col-sm-12" id="recap-telephone"><?= $personnel['telephone']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Email  :</strong>

                                <em class="col-lg-6 col-sm-12" id="recap-email"><?= $personnel['email']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Date de prise de service :</strong>

                                <em class="col-lg-6 col-sm-12" id="recap-date_prise_service" ><?= $personnel['date_prise_service']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Adresse :</strong>

                                <em class="col-lg-6 col-sm-12" id="recap-adresse" ><?= $personnel['adresse']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Pays :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-pays" ><?= $personnel['pays']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Type de personnel :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-type_personnel" ><?= $personnel['type_personnel']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Login :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-login" ><?= $personnel['login']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Sexe :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-sexe" ><?= ($personnel['sexe']??"" == 'H')? 'Masculin' : 'Féminin' ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Assurance :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-assurance" ><?= $personnel['assurance']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Autres :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-autres" ><?= $personnel['autres']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Fonction :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-fonciton" ><?= $personnel['fonction']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <strong class="col-lg-6 col-sm-12">Salle de Classe :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-salle_classe" ><?= $personnel['salle_classe']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- <div class="col-lg-6 col-sm-12"> -->
                            <!-- <div class="row">
                                <strong class="col-lg-6 col-sm-12">Fonction :</strong>

                                <em class="col-lg-6 col-sm-12"  id="recap-fonciton" ><?= $personnel['fonction']??"" ?></em>
                            </div>
                        </div> -->

                        <div class="col-lg-6 col-sm-12">
                            <div class="row">
                                <a href="#" id="recap-pieces_jointes" class="btn btn-social btn-min-width mb-1 mr-1"><span class="fa fa-download font-medium-4"></span> Télécharger piece jointe</a>
                            </div>
                        </div>
                        <!-- <input type="file" class="inputfile"  accept="image/*" style="display: none;" name="photo_autres" id="photo_autres" onchange="readURL(this, '.photo_autres');" />
                        <label for="photo_autres" style="  display: block; margin-left: auto; margin-right: auto;">
                            <figure>
                                <img title="cliquer pour modifier une piece jointe" width="200px" height="200px" src="<?= URL::base() ?>ressources/uploads/img/personnel/<?= $personnel['photo']??"" ?>" alt="" class="photo_autres " >
                            </figure>
                        </label> -->
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" onclick="redirectTo()" class="btn btn-outline-primary">Modifier</button>
            </div>
        </div>
    </div>
</div>
