<div class="card-body">
    <section class="card">
        <div id="invoice-template" class="card-body bg-light rounded">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                    <div class="media">
                        <img src="http://127.0.0.1/ges-school/public/assets/app-assets/images/logo/logo-80x80.png" alt="company logo" class="">
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
                    <p class="pb-3" id="recap-reference">88AB109690</p>
                    <ul class="px-0 list-unstyled">
                        <li>Solde à payer</li>
                        <li class="lead text-bold-800"><strong class="text-danger" id="recap-total-top">823404</strong></li>
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
                        <li class="text-bold-800">Elève : <strong id="recap-nom">kakambi franck</strong></li>
                        <li>Classe : <strong id="recap-classe">Petite-section</strong></li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-right">
                    <p><span class="text-muted">Date de facturation :</span> <strong id="recap-date">Mercredi, 18 Novembre 2020</strong></p>

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
                            <tbody id="recap-body"><tr>   <th scope="row">1</th>       <td>           <p>Pension : Scolarité</p>           <em class="text-muted">Concernant les tranches suivantes :  Février.Mars.Avril..</em>       </td>       <td class="text-right">100000 Fcfa</td>       <td class="text-right">3</td>       <td class="text-right">300000 Fcfa</td></tr><tr>   <th scope="row">2</th>       <td>           <p>Pension : Inscription</p>       </td>       <td class="text-right">100000 Fcfa</td>       <td class="text-right">2</td>       <td class="text-right">200000 Fcfa</td></tr><tr>   <th scope="row">3</th>       <td>           <p>Pension : Cantine </p>           <em class="text-muted">Concernant les tranches suivantes : Février.Mars.Avril..</em>       </td>       <td class="text-right">50000 Fcfa</td>       <td class="text-right">3</td>       <td class="text-right">150000 Fcfa</td></tr><tr>   <th scope="row">4</th>       <td>           <p>Pension des activités : Karaté, Corale. </p>           <em class="text-muted">Concernant les tranches suivantes : Février.Avril..</em>       </td>       <td class="text-right">98633 Fcfa</td>       <td class="text-right">3</td>       <td class="text-right">591798 Fcfa</td></tr><tr>   <th scope="row">5</th>       <td>           <p>Pension : BIPOLAIRE</p>       </td>       <td class="text-right">3454 Fcfa</td>       <td class="text-right">  1 </td>       <td class="text-right">3454 Fcfa</td></tr></tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 col-sm-12 text-center text-md-left">
                        <p class="lead">Mode de paiement:&nbsp;<strong id="recap-mode_paiement">Espèce</strong></p>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td id="recap-banque" style="display: none;"></td>
                                            <td class="text-right" id="recap-nom_banque" style="display: none;">: </td>
                                        </tr>
                                        <tr>
                                            <td id="recap-cheque" style="display: none;">:</td>
                                            <td class="text-right" id="recap-numero_cheque" style="display: none;"></td>
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
                                        <td class="text-right"><strong id="recap-sous_total">823071</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Remise</td>
                                        <td class="text-right"><strong id="recap-reduction">38983</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Reste</td>
                                        <td class="text-right"><strong id="recap-reste">0333</strong></td>
                                    </tr>
                                    <!-- <tr>
                                        <td class="text-bold-800">Total</td>
                                        <td class="text-bold-800 text-right"> <strong id="recap-total"> Fcfa</strong></td>
                                    </tr> -->
                                    <tr class="bg-grey bg-lighten-4">
                                        <td class="text-bold-800">Solde à payer</td>
                                        <td class="text-bold-800 text-right text-danger"><strong id="recap-total-bottom">823404</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <p>Personne habilitée</p>
                            <!-- <img src="http://127.0.0.1/ges-school/public/assets/app-assets/images/pages/signature-scan.png" alt="signature" class="height-100"/> -->
                            <h6 id="recap-signataire">Charbonnier LaRose</h6>
                            <p class="text-muted" id="recap-funtion_signataire">Le Sécrétariat</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <!-- Invoice Footer -->
            <div id="invoice-footer">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <h6>Conditions générales</h6>
                        <p>Après paiement, votre argent est non-remboursable.</p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                    
                    <div class="loader-container">
                        <div id="loading" class="line-scale-party loader-warning" style="">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                        

                        <a href="#" id="btn_save" class="btn btn-green my-1"><i class="fa fa-floppy-o"></i> Enregistrer</a>
                        <a href="http://127.0.0.1/ges-school/public/accueil" id="btn_home" class="btn btn-blue my-1" style="display: none;"><i class="fa fa-home"></i> Liste des élèves</a>
                        
                        <a href="#" id="btn_back" class="btn btn-warning my-1"><i class="fa fa-arrow-left"></i> Retour</a>
                        <a href="http://127.0.0.1/ges-school/public/print/scolarite" target="_blank" id="btn_print" class="btn btn-danger my-1" style="display: none;"><i class="fa fa-print"></i> Imprimer</a>
                    </div>
                </div>
            </div>
            <!--/ Invoice Footer -->

        </div>
    </section>
</div>