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
    
    require "script-event.php";
    require "script-component-init.php";
    require "script-update-etat.php";
    require "script-save.php";
    require "script-versement_scolarite.php";

    $include_footer_script = ob_get_clean();

    $include_res_header =  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">';
    $include_res_header .=  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/loaders/loaders.min.css">';

    $readonly = '';
    // if(isset($_SESSION['DATA_TRANSPORT'])){
        //  var_dump($_SESSION['DATA_TRANSPORT']);
        
        // $CODE_ELEVE = $_SESSION['DATA_TRANSPORT']['CODE_ELEVE'];
        // $CODE_CLASSE = $_SESSION['DATA_TRANSPORT']['CODE_CLASSE'];
        // $CODE_PARCOURS = $_SESSION['DATA_TRANSPORT']['CODE_PARCOURS'];

        // $MATRICULE = $_SESSION['DATA_TRANSPORT']['MATRICULE'];
        // $NOM = $_SESSION['DATA_TRANSPORT']['NOM'];
        // $PRENOM = $_SESSION['DATA_TRANSPORT']['PRENOM'];
        // $SEXE = $_SESSION['DATA_TRANSPORT']['SEXE'];
        // $DATE_NAISSANCE = $_SESSION['DATA_TRANSPORT']['DATE_NAISSANCE'];
        // $LIEU_NAISSANCE = $_SESSION['DATA_TRANSPORT']['LIEU_NAISSANCE'];
    // }

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
                    
                                        <p class=" font-medium-2"><h2P style="color:black;font-family:Niagara Engraved; font-size: 28px;">Renseigner toutes les informations concernant le versement.</h2P></p>
                                      <!--   <p class="font-medium-2"><strong class="red">NB !!!</strong> Preciser l'année scolaire en cours ou, <a href="<?= URL::link('annee_scolaire');?>" class="alert-link">Créer une?</a></p>.-->
                                    </div>

                                </div>  
                                    
                                <div class="col-md-5 ">
                                    <div class="alert alert-warning alert-dismissible row" role="alert">
                                        <!-- <span class="alert-icon"><i class="fa fa-warning"></i></span> -->
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <label for="annee_scolaire" class="col-form-label  text-bold-700 text-danger">Année scolaire:</label>
                                        <div class="col-8">
                                            <select id="annee_scolaire" class="select2 form-control" name="annee_scolaire" required>
                                                <?php
                                                foreach($annee_scolaires as $item) { 
                                                    ?>
                                                    <option value="<?= $item['id']; ?>" <?= (isset($data_inscriptpion) && ($data_inscriptpion['code_annee_scolaire'] == $item['id']))? 'selected' : ''; ?>><?= $item['libelle']; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <!-- <p><strong>NB!</strong>Preciser l'année scolaire en cours ou, <a href="#" class="alert-link">Creer une?</a></p>. -->
                                    </div>
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

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 class="form-section text-warning" align="">
                                                                                <strong>Informations utiles</strong>
                                                                            </h4>
                                                                        </div>
                                                                    </div>
<!-- Nom complet et classe -->
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="eleve_nom_complet" class="col-4 col-form-label">Nom Complet:</label>
                                                                                <div class="col-8">
                                                                                    <select id="eleve_nom_complet" class="select2 form-control" name="eleve_nom_complet" required>
                                                                                        <?php foreach($eleves as $item){?>
                                                                                                <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né ".$item['date_naissance']." à ".$item['lieu_naissance']; ?>" value="<?= $item['id']; ?>" <?= (isset($data_inscriptpion) && ($data_inscriptpion['code_eleve'] == $item['id']))? 'selected' : ''; ?>><?= $item['libelle']; ?></option>
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
                                                                                        <!-- <option value="-----------">---------------</option> -->
                                                                                        <?php foreach($classes as $item){?>
                                                                                                <option data-id="<?= $item['id']; ?>" value="<?= $item['id']; ?>" <?= (isset($data_inscriptpion) && ($data_inscriptpion['code_classe'] == $item['id']))? 'selected' : ''; ?>><?= $item['libelle']; ?></option>
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

<!-- Relation familiale -->
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="relation_familial_input" class="col-4 col-form-label">Autres enfants scolarisés à l'école:</label>
                                                                                <div class="col-8">
                                                                                    <textarea disabled placeholder="Autres enfants scolarisés à l'école" class="form-control" style="min-height: 100px; max-height: 100px;" id="relation_familial_input" name="motif"><?= $value??""; ?></textarea>
                                                                                    <?php  ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                            <div class="col-1">
                                                                                   
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <button type="button" id="btn-open-modal-familyship" class="btn btn-warning btn-darken" data-toggle="modal" data-target="#modal-familyship">Ajouter</button>
                                                                                </div>
                                                                                <div class="col-8">

                                                                                        <input placeholder="Reduction" type="text" class="form-control reduction" id="RFT-reduction" name="RFT-reduction" readonly/>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 class="form-section text-warning" align="">
                                                                               
                                                                            </h4>
                                                                        </div>
                                                                    </div>
<!-- Scolarite -->
        <?php $i = 0;
            foreach($type_pensions as $item){  ?>
                <div class="row">

                    <div class="col-3 ">
                        <fieldset class="mb-1">
                            <h5>Type Pension</h5>
                            <div class="form-group">
                            <?= '<input type="text" readonly class="form-control " value="'.$item['libelle'].'"  id="COL2-'.$item['id'].'"  name="COL2-'.$item['id'].'"  placeholder="" />'; ?>
                            </div>
                        </fieldset>
                    </div>

                    <div id="TYPE-SELECT-<?= $item['id']; ?>" class="col-4">
                        <fieldset class="mb-1">
                            <h5>Multiplicateur</h5>
                            <div class="form-group">
                                <select class="select2 form-control" multiple="multiple"  id="SELECT-COL3-<?= $item['id'];?>"  name="SELECT-COL3-<?= $item['id'];?>"   required>
                                <?php foreach($tranche_scolaires as $tranche_scolaire){?>
                                        <option value="<?= $tranche_scolaire['id']; ?>" ><?= $tranche_scolaire['libelle']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                
                    <div id="TYPE-NUMBER-<?= $item['id']; ?>" class="col-4">
                        <fieldset class="mb-1">

                            <h5>Multiplicateur</h5>                                                                         <div class="form-group">
                                <input type="number" class="form-control " value="0"  id="NUMBER-COL3-<?= $item['id'];?>"  name="NUMBER-COL3-<?= $item['id'];?>"    placeholder="">
                            </div>
                        </fieldset>
                    </div> 


                    <div class="col-2">
                        <fieldset class="mb-1">
                            <h5>Reduction</h5>
                            <div class="form-group">
                                <input type="number" class="form-control reduction"  id="COL5-<?= $item['id'];?>" value="0"  name="COL5-<?= $item['id'];?>"   placeholder="" />
                            </div>
                        </fieldset>
                    </div>


                    <div class="col-3">
                        <fieldset class="mb-1">
                            <h5>Recaputilatif</h5>
                            <div class="form-group">
                                <input type="text" class="form-control "  id="COL4-<?= $item['id'];?>" value="0"  name="COL4-<?= $item['id'];?>"   placeholder="" readonly/>
                            </div>
                        </fieldset>
                    </div>
                </div>
        <?php    }  ?>
<!-- Cantine -->
                                                                    <div class="row">

                                                                        <div class="col-3 ">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Type pension</h5>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control  " readonly value="Cantine"  id="COL2-Cantine"   COL2-Cantine"  placeholder="" />   
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div id="" class="col-4">
                                                                                <fieldset class="mb-1">
                                                                                    <h5>Multiplicateur</h5>
                                                                                    <div class="form-group">
                                                                                        <select class="select2 form-control" multiple="multiple"  id="SELECT-COL3-Cantine"  name="SELECT-COL3-Cantine"   required>
                                                                                        <?php foreach($tranche_scolaires as $tranche_scolaire){?>
                                                                                                <option value="<?= $tranche_scolaire['id']; ?>" ><?= $tranche_scolaire['libelle']; ?></option>
                                                                                        <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </fieldset>
                                                                        </div> 

                                                                        <div class="col-2">

                                                                            <fieldset class="mb-1">
                                                                                <h5>Reduction</h5>
                                                                                <div class="form-group">
                                                                                    <input type="number" class="form-control reduction"  id="COL5-Cantine" value="0"  name="COL5-Cantine"   placeholder="" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div class="col-3">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Recaputilatif</h5>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control "  id="COL4-Cantine" value="0"  name="COL4-Cantine"   placeholder="" readonly/>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>
<!-- Activite -->
                                                                    <div class="row">

                                                                        <div class="col-3 ">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Activité</h5>
                                                                                <div class="form-group">
                                                                                    <select class="select2 form-control" multiple="multiple"  id="SELECT-COL2-Activite"  name="SELECT-COL2-Activite"   required>
                                                                                    <?php foreach($activites as $activite){?>
                                                                                            <option value="<?= $activite['id']; ?>" title="<?= $activite['montant']; ?>" ><?= $activite['libelle']; ?></option>
                                                                                    <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div id="" class="col-4">
                                                                                <fieldset class="mb-1">
                                                                                    <h5>Multiplicateur</h5>
                                                                                    <div class="form-group">
                                                                                        <select class="select2 form-control" multiple="multiple"  id="SELECT-COL3-Activite"  name="SELECT-COL3-Activite"   required>
                                                                                        <?php foreach($tranche_scolaires as $tranche_scolaire){?>
                                                                                                <option value="<?= $tranche_scolaire['id']; ?>" ><?= $tranche_scolaire['libelle']; ?></option>
                                                                                        <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </fieldset>
                                                                        </div> 

                                                                        <div class="col-2">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Reduction</h5>
                                                                                <div class="form-group">
                                                                                    <input type="number" class="form-control reduction"  id="COL5-Activite" value="0"  name="COL5-Activite"   placeholder="" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div class="col-3">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Recaputilatif</h5>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control "  id="COL4-Activite" value="0"  name="COL4-Activite"   placeholder="" readonly/>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    
<!-- Autres Informations   -->
                                                                    <div class="row">
                                                                        <div class="col-3 ">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Autres</h5>
                                                                                <div class="form-group">
                                                                                    <input type="text" value="" class="form-control " value=""  id="COL2-Autres"  name="COL2-Autres"  placeholder="" />   
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <div id="" class="col-4">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Montant</h5>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="" class="form-control " value="0"  id="NUMBER-COL3-Autres"  name=""    placeholder="">
                                                                                </div>
                                                                            </fieldset>
                                                                        </div> 


                                                                        <div class="col-2">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Reduction</h5>
                                                                                <div class="form-group">
                                                                                    <input type="number" value="" class="form-control reduction"  id="COL5-Autres" value="0"  name="COL5-Autres"   placeholder="" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div class="col-3">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Recaputilatif</h5>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control "  id="COL4-Autres" value="0"  name="COL4-Autres"   placeholder="" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 class="form-section text-warning" align="">
                                                                               
                                                                            </h4>
                                                                        </div>
                                                                    </div>
<!-- Montant à payer -->
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

                                                                    <!-- <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 class="form-section text-warning" align="">
                                                                                <strong>Informations complémentaires</strong>
                                                                            </h4>
                                                                        </div>
                                                                    </div> -->
<!-- Reste à payer
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="reste" class="col-4 col-form-label">Reste à payer&nbsp;:</label>
                                                                                <div class="col-8">
                                                                                    <input value="0" type="number" class="form-control" id="reste" name="reste" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
    Montant de reduction 
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="reduction" class="col-4 col-form-label">Montant de réduction&nbsp;:</label>
                                                                                <div class="col-8">
                                                                                    <input placeholder="Renseigner le montant de la réduction" value="0" type="number" class="reduction form-control" id="reduction" name="reduction" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

    Motif 
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="motif" class="col-4 col-form-label">Motif :</label>
                                                                                <div class="col-8">
                                                                                    <textarea placeholder="Renseigner le motif du versement" class="form-control" style="min-height: 100px; max-height: 100px;" id="motif" name="motif"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
    Autre détails 
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="autres" class="col-4 col-form-label">Autres détails:</label>
                                                                                <div class="col-8">
                                                                                    <textarea placeholder="Renseigner toutes autres informations sur ce versement" class="form-control" style="min-height: 100px; max-height: 100px;" id="autres" name="autres"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
-->

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
<!--                 
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                        </div>
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-1">
                                                                            <a id="btn_preview" type="button" class="btn btn-warning my-1"><i class="fa fa-arrow-right"></i> Suivant</a>
                                                                        </div>
                                                                    </div> -->

                                                                    
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
                </div>
            </section>

            
            <?php include "versement_scolarite_etat.php"; ?>


        </div>
    </div>
</div>


<div class="modal animated fadeInDownBig text-left" id="modal-familyship" tabindex="-1" role="dialog" aria-labelledby="myModalLabel40" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel40">Affectation des relations familiales </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form  class="needs-validation" id="create-form" method="POST"  action="" novalidate>
                <div class="modal-body">
                    <div class="form-group">

                        <select id="family-relation" class="select-multiple-2 form-control" name="multi_select[]" id="multi_select" style="width:100%;">
                            <option data-matricule="" data-id="" disabled value="">----------------------</option>
                            <?php foreach($eleves as $item){?>
                            <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né ".$item['date_naissance']." à ".$item['lieu_naissance']; ?>" value="RF-<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group">
                        <input type="number" id="RF-reduction" class="form-control" >
                        <input type="hidden" id="OLD-RF-reduction" class="reduction form-control" >
                    </div>

                </div>
                <div id="loading" class="spinner-grow text-warning" role="status"> <span class="sr-only">Loading...</span></div>
                <div class="modal-footer" id="button-form-create">
                    <input type="reset" id="btn-save-family-relation" class="btn btn-warning" data-dismiss="modal" value="Valider">
                    <input type="reset" id="btn-cancel-family-relation" class="btn btn-danger" data-dismiss="modal" value="Annuler">
                </div>
            </form>
            
        </div>
    </div>
</div>
