<?php
    //session_start();
?>
<!DOCTYPE html>

<html class="loaded" data-textdirection="ltr">
    <?php
        // RECUPERATION DES DONNEES VENANT DE L'INSCRIPTION
        // array(
        //       "eleve_id" => $eleve_id,
        //       "classe_id" => $classe_id,
        //       "classe_information" => $classe_information
        // );
        //$data = $_SESSION["DATA_TRANSPORT"];

        require_once "head.php";
        // require_once "../app/Helpers/_magic_tools.php";
    ?>

    <body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
    <?php
        require_once "navbar.php";
    ?>
    <div class="app-content content bg-warningcreated22">
        <div class="content-wrapper">

            <div class="content-body">

            <section class="row" id="recapitulatif">
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
                                                        <img src="app-assets/images/logo/logo-80x80.png" alt="company logo" class=""/>
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
                                                    <p class="pb-3"># FAC-001001</p>
                                                    <ul class="px-0 list-unstyled">
                                                        <li>Solde à payer</li>
                                                        <li class="lead text-bold-800"><strong class="text-danger">165 000 Fcfa </strong></li>
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
                                                        <li class="text-bold-800">Elève : <strong>MBA NGUEMA Franck</strong></li>
                                                        <li>Salle de classe : <strong>Cours-Moyen I</strong></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 col-sm-12 text-center text-md-right">
                                                    <p><span class="text-muted">Date de facturation :</span> <strong>06/05/2020</strong></p>

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
                                                                    <th>#</th>
                                                                    <th>Objet et description</th>
                                                                    <th class="text-right">Montant</th>
                                                                    <th class="text-right">Quantité</th>
                                                                    <th class="text-right">Montant Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">1</th>
                                                                    <td>
                                                                        <p>Tranche d'inscription</p>
                                                                        <em class="text-muted">Il s'agit d'une tranche spéciale réservé à l'inscription de l'élève.</em>
                                                                    </td>
                                                                    <td class="text-right">80 000 Fcfa</td>
                                                                    <td class="text-right">1</td>
                                                                    <td class="text-right">80 000 Fcfa</td>
                                                                </tr>

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
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-7 col-sm-12 text-center text-md-left">
                                                        <p class="lead">Mode de paiement:&nbsp;<strong>Par chèque</strong></p>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <table class="table table-borderless table-sm">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Nom de la banque:</td>
                                                                            <td class="text-right">UBA Bank</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>N° du chèque:</td>
                                                                            <td class="text-right">UBA165461646546AA</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 col-sm-12">
                                                        <p class="lead">Montant total dû</p>
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Sous-Total</td>
                                                                        <td class="text-right"><strong>180 000 Fcfa</strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Remise</td>
                                                                        <td class="text-right"><strong>15 000 Fcfa</strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-bold-800">Total</td>
                                                                        <td class="text-bold-800 text-right"> <strong>165 000 Fcfa</strong></td>
                                                                    </tr>
                                                                    <tr class="bg-grey bg-lighten-4">
                                                                        <td class="text-bold-800">Solde à payer</td>
                                                                        <td class="text-bold-800 text-right text-danger"><strong>165 000 Fcfa</strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="text-center">
                                                            <p>Personne habilitée</p>
                                                            <img src="app-assets/images/pages/signature-scan.png" alt="signature" class="height-100"/>
                                                            <h6>Charbonnier LaRose</h6>
                                                            <p class="text-muted">Le Sécrétariat</p>
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

                                                        <button type="button" class="btn btn-green my-1"><i class="fa fa-floppy-o"></i> Enregistrer</button>
                                                        <button type="button" class="btn btn-blue my-1"><i class="fa fa-home"></i> Accueil</button>

                                                        <button type="button" class="btn btn-warning my-1"><i class="fa fa-arrow-left"></i> Retour</button>
                                                        <button type="button" class="btn btn-danger my-1"><i class="fa fa-print"></i> Imprimer</button>
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
            </div>
        </div>
    </div>

    
   
    <?php  require_once "footer.php"; ?>
    
    <script>
        var elems = document.getElementsByClassName('ajouter-montant');

        var myLength = elems.length,
            total = 0;

        for (var i = 0; i < myLength; ++i) {
            total += elems[i].value;
        }

        document.getElementById('montant').value = total;
    </script>
    </body>
</html>