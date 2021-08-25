<?php
    use App\Helpers\S;
    use Core\Routing\URL;

    ob_start();
   
	echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
    //switch bootstrap https://github.com/Bttstrp/bootstrap-switch [https://github.com/Bttstrp/bootstrap-switch/issues/343]
    echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>';
	echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>';
    // echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
    echo '<script src="'.URL::base().'assets/app-assets/vendors/js/jquery-print/jQuery.print.js"></script>';
    
    require "script-component-init.php";
    require "script-save.php";
    require "script-update-etat.php";
    require "script-versement_inscription.php";

    $include_footer_script = ob_get_clean();

    $include_res_header =  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">';
    $include_res_header .=  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/loaders/loaders.min.css">';

    $readonly = '';

?>


<div class="app-content content bg-warningcreated22">
    <div class="content-wrapper">

        <div class="content-body">

            <section class="row" id="section_versement">
                <div class="col-sm-12">
                    <!-- ESPACE DE TRAVAIL -->
                    <div id="kick-start" class="border-2 border-warning card box-shadow-2">
                        <div class="card-header border-bottom-2 border-bottom-warning card-header-inverse ">
                            <h4 class="card-title center text-uppercase">
                                Versement de pension
                            </h4>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body">
                            <!-- Année scolaire -->
                            <div class="row" >
                                <div class="col-md-7">
                                    <div class="card-text">
                    
                                        <p ><h2P style="color:black; font-size: 18px;">Renseigner toutes les informations concernant une Inscription</h2P></p>
                                      <!--   <p class="font-medium-2"><strong class="red">NB !!!</strong> Preciser l'année scolaire en cours ou, <a href="<?= URL::link('annee_scolaire');?>" class="alert-link">Créer une?</a></p>.-->
                                    </div>

                                </div>  
                                    
                                <div class="col-md-5 ">
                                   
                                </div>

                            </div>  
                                
                                
                                <div class="">
                                    <section id="validation">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <div class="card-content collapse show">
                                                        <div class="card-body">
                                                            <form id="form_versement" action="need-validation" class="" novalidate>
                                                                <fieldset>

                                                                   
<!-- Nom complet et classe -->
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="eleve_nom_complet" class="col-4 col-form-label">Nom Complet:</label>
                                                                                <div class="col-8">
                                                                                    <select id="eleve_nom_complet" class="select2 form-control" name="eleve_nom_complet" required>
                                                                                        <?php foreach($eleves as $item){?>
                                                                                                <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né ".$item['date_naissance']." à ".$item['lieu_naissance']; ?>" value="<?= $item['id']; ?>" <?= (isset($data_inscriptpion) && ($data_inscriptpion['code_eleve'] == $item['id']))? 'selected' : ''; ?>><?= $item['nom_complet']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>

                                                                            </div>

                                                                            <div class="valid-feedback">Valider.</div>
                                                                            <div class="invalid-feedback">
                                                                                Veuillez remplir ce champ.
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="classe" class="col-1 col-form-label"></label>
                                                                                <label for="classe" class="col-3 col-form-label">Classe:</label>
                                                                                <div class="col-8">

                                                                                    <select id="classe" class="select2 form-control" name="classe" required>
                                                                                        <option data-montant="0"  data-id="<?= $item['id']; ?>" selected value="----"> selecionnez une classe</option>
                                                                                        <?php foreach($pension_classe as $item){?>
                                                                                                <option  data-montant="<?= $item['montant']; ?>" data-pension_classe_id="<?= $item['id']; ?>" value="<?= $item['classe_id']; ?>" ><?= $item['classe_libelle']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="valid-feedback">Valider.</div>
                                                                            <div class="invalid-feedback">
                                                                                Veuillez remplir ce champ.
                                                                            </div>
                                                                        </div>
                                                                    </div>



                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="montant" class="col-4 col-form-label">Montant à payer&nbsp;:</label>
                                                                                <div class="col-8">
                                                                                    <input readonly  placeholder="" value="0" type="number" class="form-control" id="montant" name="montant" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
<!-- Date de versement -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="date_paiement" class="col-4 col-form-label">Date de versement&nbsp;:</label>
                                                                                <div class="col-8">
                                                                                    <input type="date" class="form-control" value="<?= date("Y-m-d");?>" id="date_paiement" name="date_paiement" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <!-- Type de paiement -->
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="type_paiement" class="col-4 col-form-label">Type de paiement:</label>
                                                                                <div class="col-8">
                                                                                    <select id="type_paiement" class="select2 form-control" name="type_paiement" required>
                                                                                        <?php
                                                                                        foreach($type_paiements as $item) { 
                                                                                            ?>
                                                                                            <option value="<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="valid-feedback">Valider.</div>
                                                                            <div class="invalid-feedback">
                                                                                Veuillez remplir ce champ.
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-1">
                                                                            <a id="btn_preview" type="button" class="btn btn-warning my-1"><i class="fa fa-arrow-right"></i> Suivant</a>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer border-top-2 border-top-warning">
                            <span>Ges-School</span>
                        </div>
                    </div>
            </section>
                    </div>
            
                                                                                            
            <?php require "versement_inscription_etat.php"; ?>


        </div>
    </div>
</div>

