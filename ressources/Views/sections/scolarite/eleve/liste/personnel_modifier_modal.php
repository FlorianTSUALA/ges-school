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
                        <input type="file" class="inputfile" style="display: none;"  accept="image/*" name="photo" id="photo" onchange="readURL(this, '.photo');" />
                        <label for="photo" style="  display: block; margin-left: auto; margin-right: auto;">
                            <figure>
                                <img title="cliquer pour modifier une photo" width="200px" height="200px"  src="<?= URL::base() ?>ressources/uploads/img/personnel/no-photo.jpg" alt="" class="photo" class="center">
                            </figure>
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Nom :</strong>

                                <em id="recap-nom" class="col-6"><?= $personnel['nom']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-2">

                        </div>

                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Prénom :</strong>

                                <em id="recap-prenom" class="col-6"><?= $personnel['prenom']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Téléphone :</strong>

                                <em class="col-6" id="recap-telephone"><?= $personnel['telephone']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-2">

                        </div>

                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Email  :</strong>

                                <em class="col-6" id="recap-email"><?= $personnel['email']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Date de prise de service :</strong>

                                <em class="col-6" id="recap-date_prise_service" ><?= $personnel['date_prise_service']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-2">

                        </div>

                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Adresse :</strong>

                                <em class="col-6" id="recap-adresse" ><?= $personnel['adresse']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Pays :</strong>

                                <em class="col-6"  id="recap-pays" ><?= $personnel['pays']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-2">

                        </div>

                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Type de personnel :</strong>

                                <em class="col-6"  id="recap-type_personnel" ><?= $personnel['type_personnel']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Login :</strong>

                                <em class="col-6"  id="recap-login" ><?= $personnel['login']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-2">

                        </div>

                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Sexe :</strong>

                                <em class="col-6"  id="recap-sexe" ><?= $personnel['sexe']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Assurance :</strong>

                                <em class="col-6"  id="recap-assurance" ><?= $personnel['assurance']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-2">

                        </div>

                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Autres :</strong>

                                <em class="col-6"  id="recap-autres" ><?= $personnel['autres']??"" ?></em>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Fonction du personnel :</strong>

                                <em class="col-6"  id="recap-fonciton" ><?= $personnel['fonction']??"" ?></em>
                            </div>
                        </div>

                        <div class="col-2">

                        </div>

                        <!-- <div class="col-5">
                            <div class="row">
                                <strong class="col-6">Autres :</strong>

                                <em class="col-6"  id="recap-autres" >6 ans</em>
                            </div>
                        </div> -->
                    </div>

                    <div class="row">
                        <input type="file" class="inputfile"  accept="image/*" style="display: none;" name="photo_autres" id="photo_autres" onchange="readURL(this, '.photo_autres');" />
                        <label for="photo_autres" style="  display: block; margin-left: auto; margin-right: auto;">
                            <figure>
                                <img title="cliquer pour modifier une piece jointe" width="200px" height="200px" src="<?= URL::base() ?>ressources/uploads/img/personnel/<?= $personnel['photo']??"" ?>" alt="" class="photo_autres " >
                            </figure>
                        </label>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" id="btn-action-edit" class="btn btn-outline-primary">Modifier</button>
            </div>
        </div>
    </div>
</div>