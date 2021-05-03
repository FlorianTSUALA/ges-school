
<page>

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
                <h2>REÇU DE PAIEMENT DE FRAIS DE CANTINE</h2>
                <p class="pb-3" id="recap-reference">CD20ECE29B</p>
                <ul class="px-0 list-unstyled">
                    <li>Solde à payer</li>
                    <li class="lead text-bold-800"><strong class="text-danger" id="recap-total-top">99</strong></li>
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
                <p><span class="text-muted">Date de facturation :</span> <strong id="recap-date">Dimanche, 01 Novembre 2020</strong></p>

            </div>
        </div>
        <!--/ Invoice Customer Details -->

        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-2">

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
                                    <td class="text-right"><strong id="recap-sous_total">99</strong></td>
                                </tr>
                                <tr>
                                    <td>Remise</td>
                                    <td class="text-right"><strong id="recap-reduction">0</strong></td>
                                </tr>
                                <!-- <tr>
                                    <td>Reste</td>
                                    <td class="text-right"><strong id="recap-reste"> Fcfa</strong></td>
                                </tr> -->
                                <!-- <tr>
                                    <td class="text-bold-800">Total</td>
                                    <td class="text-bold-800 text-right"> <strong id="recap-total"> Fcfa</strong></td>
                                </tr> -->
                                <tr class="bg-grey bg-lighten-4">
                                    <td class="text-bold-800">Solde à payer</td>
                                    <td class="text-bold-800 text-right text-danger"><strong id="recap-total-bottom">99</strong></td>
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
            </div>
            </div>
        </div>
        <!--/ Invoice Footer -->

    </div>
<br>
<span style="font-size: 20px; font-weight: bold">Titre d'en tete repetée une seule flois<br></span>
<br>
<br>



<table cellspacing="0" style="width: 100%; border: solid 2px #000000; ">
    <tr>
        <td style="width: 100%; font-size: 12pt;">
            <span style="font-size: 15pt; font-weight: bold;">ADRESSE DE RETOUR<br></span>
            <br>
            <b>Entrepot des Bois</b><br>
            
        </td>
    </tr>


</table>

           
<table cellspacing='0'>
    <colgroup>
        <col style="width: 8%">
        <col style="width: 47%">
        <col style="width: 15%">
        <col style="width: 15%">
        <col style="width: 15%">
    </colgroup>
    <thead>
        <tr>
            <th>Numero</th>
            <th>Object et description</th>
            <th>Montant</th>
            <th>Quantité</th>
            <th>Montant total</th>
        </tr>
    </thead>
    <tbody>
        <tr>   
            <th scope="row">1</th>       
            <td>           <p>Periode : undefined </p>           <em class="text-muted">A compter du  : 2020-11-01.</em>       </td>       
            <td class="text-right">33 Fcfa</td>       
            <td class="text-right">1</td>       
            <td class="text-right">33 Fcfa</td>
        </tr>
        <tr>   
            <th scope="row">2</th>       
            <td>           <p>Periode : undefined </p>           <em class="text-muted">A compter du  : 2020-11-01.</em>       </td>       
            <td class="text-right">33 Fcfa</td>       
            <td class="text-right">1</td>       
            <td class="text-right">33 Fcfa</td>
        </tr>
        <tr>   
            <th scope="row">3</th>       
            <td>           <p>Periode : undefined </p>           <em class="text-muted">A compter du  : 2020-11-01.</em>       </td>       
            <td class="text-right">33 Fcfa</td>       
            <td class="text-right">1</td>       
            <td class="text-right">33 Fcfa</td>
        </tr>

    </tbody>

    <tfoot>
        <tr>
            <th colspan="7" style="font-size: 16px;">
                [[page_cu]]/[[page_nb]]
            </th>
        </tr>
    </tfoot>
    
</table>
<br><br><br>

</page>