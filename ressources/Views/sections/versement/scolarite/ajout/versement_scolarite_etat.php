<?php

use Core\Routing\URL;
use App\Controller\PrinterController;

    // $reference = 001001;
    // $somme =  165000;
    // $nom =  "KAKAMBI";
    // $prenom =  "Franck Cabrel";
    // $classe =  "Cours-Moyen I";
    // $date_facture = Helpers::getFullDate(date("Y-m-d H:i:s")) ;//date('M dS ,Y', time());
    // $typepaiement = "Tranche d'inscription";
    // $description = "Il s'agit d'une tranche spéciale réservé à l'inscription de l'élève.";
    // $prix = 80000;
    // $quantite = 1;
    // $somme = 80000;
    // $nom_banque = "UBA BANK";
    // $mode_paiement = "Par chèque";
    // $banque= "Nom de la banque";
    // $cheque= "N° du chèque";
    // $numero_cheque= "UBA165461646546AA";
    // $total = 165000;
    // $remise = 15000;
    // $reste = 0;
    // $signataire = "Charbonnier LaRose";
    // $funtion_signataire = "Le Sécrétariat";
    // $numero_ligne = 1;
    // $sous_total = 180000;

?>


<section class="row" id="section_recaputilatif" style="display: none;">
    <div class="col-sm-12">
        <!-- ESPACE DE TRAVAIL -->
        <div id="kick-start" class="border-2 border-warning card box-shadow-2">
            <div class="card-header border-bottom-2 border-bottom-warning card-header-inverse ">
                <h4 class="card-title center text-uppercase">
                    Vérification des informations de paiement
                </h4>
            </div>

            <div class="card-content collapse show">
                <div class="card-body">
                    <section class="card">
                        <div id="invoice-template" class="card-body bg-light rounded">
                            <!-- Invoice Company Details -->
                            <div id="invoice-company-details" class="row">
                                <div class="col-md-6 col-sm-12 text-center text-md-left">
                                    <div class="media">
                                        <img src="<?= URL::base() ?>assets/app-assets/images/logo/logo-80x80.png" alt="company logo" class=""/>
                                        <div class="media-body">
                                            <ul class="ml-2 px-0 list-unstyled">
                                                <li class="text-bold-800"><h2>Les comilines</h2></li>
                                                <li>Batterie 4 </li>
                                                <li>Libreville, Gabon</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 text-center text-md-right">
                                    <h2>REÇU DE VERSEMENT</h2>
                                    <p class="pb-3" id="recap-reference"> <strong>Réference : </strong> <?= $reference??"" ;?> </p>
                                    <ul class="px-0 list-unstyled">
                                        <li>Solde à payer</li>
                                        <li class="lead text-bold-800"><strong class="text-danger" id="recap-total-top"><?= $somme??"" ;?> Fcfa</strong></li>
                                    </ul>
                                </div>
                            </div>
                            <!--/ Invoice Company Details -->

                            <!-- Invoice Customer Details -->
                            <div id="invoice-customer-details" class="row pt-2">
                                <div class="col-sm-12 text-center text-md-left">
                                    <p class="text-muted">Facture de</p>
                                </div>
                                <div class="col-md-6 col-sm-12 text-center text-md-left">
                                    <ul class="px-0 list-unstyled">
                                        <li class="text-bold-800">Elève : <strong id="recap-nom"><?= $nom??""; ?>.' '.<?= $prenom??""; ?> </strong></li>
                                        <li>Classe : <strong id="recap-classe"><?= $classe??"" ;?></strong></li>
                                    </ul>
                                </div>
                                <div class="col-md-6 col-sm-12 text-center text-md-right">
                                    <p><span class="text-muted">Date de facturation :</span> <strong id="recap-date"><?= $date_facture??"" ;?></strong></p>

                                </div>
                            </div>
                            <!--/ Invoice Customer Details -->

                            <!-- Invoice Items Details -->
                            <div id="invoice-items-details" class="pt-2">
                                <div class="row">
                                    <div class="table-responsive col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Numéro</th>
                                                    <th>Objet et description</th>
                                                    <th class="text-right">Montant</th>
                                                    <th class="text-right">Quantité</th>
                                                    <th class="text-right">Montant Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recap-body">
                                                <!-- <tr>
                                                    <th scope="row" id="recap-numero_ligne"><?= $numero_ligne??"" ;?></th>
                                                    <td>
                                                        <p id="recap-typepaiement"><?= $typepaiement??"" ;?></p>
                                                        <em class="text-muted" id="recap-description"><?= $description??"";?></em>
                                                    </td>
                                                    <td class="text-right" id="recap-prix"><?= $prix??"";?> Fcfa</td>
                                                    <td class="text-right" id="recap-quantite"><?= $quantite??"";?></td>
                                                    <td class="text-right" id="recap-somme"><?= $somme??"";?> Fcfa</td>
                                                </tr> -->
                                                <!-- 
                                                    <tr>
                                                        <th scope="row">2</th>
                                                        <td>
                                                            <p>Tranche mensuelle</p>
                                                            <em class="text-muted">Il s'agit de la scolarité mensuelle d'un élève.</em>
                                                        </td>
                                                        <td class="text-right">20 000 Fcfa</td>
                                                        <td class="text-right">5</td>
                                                        <td class="text-right">100 000 Fcfa</td>
                                                    </tr> 
                                                -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 col-sm-12 text-center text-md-left">
                                        <p class="lead">Mode de paiement:&nbsp;<strong id="recap-mode_paiement"><?= $mode_paiement??"";?></strong></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td id="recap-banque"><?= $banque??"";?></td>
                                                            <td class="text-right" id="recap-nom_banque"><?= $nom_banque??"";?>: </td>
                                                        </tr>
                                                        <tr>
                                                            <td id="recap-cheque"><?= $cheque??"";?>:</td>
                                                            <td class="text-right" id="recap-numero_cheque"><?= $numero_cheque??"";?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <p class="lead">Montant total du versement</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Sous-Total</td>
                                                        <td class="text-right"><strong id="recap-sous_total"><?= $sous_total??"";?>Fcfa</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Remise</td>
                                                        <td class="text-right"><strong id="recap-reduction"><?= $remise??"";?> Fcfa</strong></td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td>Reste</td>
                                                        <td class="text-right"><strong id="recap-reste"><?= $reste??"";?> Fcfa</strong></td>
                                                    </tr> -->
                                                    <!-- <tr>
                                                        <td class="text-bold-800">Total</td>
                                                        <td class="text-bold-800 text-right"> <strong id="recap-total"><?= $total??"";?> Fcfa</strong></td>
                                                    </tr> -->
                                                    <tr class="bg-grey bg-lighten-4">
                                                        <td class="text-bold-800">Solde à payer</td>
                                                        <td class="text-bold-800 text-right text-danger"><strong id="recap-total-bottom"><?= $total??"";?>Fcfa</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center">
                                            <p>Personne habilitée</p>
                                            <!-- <img src="<?= URL::base() ?>assets/app-assets/images/pages/signature-scan.png" alt="signature" class="height-100"/> -->
                                            <h6 id="recap-signataire"><?= $signataire??"";?></h6>
                                            <p class="text-muted" id="recap-funtion_signataire"><?= $funtion_signataire??"";?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <!-- Invoice Footer -->
                            <div id="invoice-footer">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <h6>Conditions générales</h6>
                                        <p>Après paiement, votre argent est non-remboursable.</p>
                                    </div>
                                    <div class="col-md-6 col-sm-12 text-right">
                                    
                                    <div class="loader-container">
                                        <div id="loading" class="line-scale-party loader-warning" style="display:  none;">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                        

                                        <a href="#"  id="btn_save" class="btn btn-green my-1"><i class="fa fa-floppy-o"></i> Enregistrer</a>
                                        <a href="<?= URL::link('versement_liste')?>" id="btn_home" class="btn btn-blue my-1"><i class="fa fa-home"></i> Liste des versements</a>
                                        
                                        <a href="#"  id="btn_back" class="btn btn-warning my-1"><i class="fa fa-arrow-left"></i> Retour</a>
                                        <a  href="javascript:void(0)" id="btn_print" class="btn btn-danger my-1"><i class="fa fa-print"></i> Imprimer</a>
                                    </div>
                                </div>
                            </div>
                            <!--/ Invoice Footer -->

                        </div>
                    </section>
                </div>
            </div>

            <div class="card-footer border-top-2 border-top-warning">
                <span>Ges-School</span>
            </div>
        </div>
    </div>
</section>

