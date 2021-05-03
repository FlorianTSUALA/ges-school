<?php
     use Core\Routing\URL;
     use App\Helpers\S;

    ob_start();
    //select2
	echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
    //switch bootstrap https://github.com/Bttstrp/bootstrap-switch [https://github.com/Bttstrp/bootstrap-switch/issues/343]
    echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>';
	echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>';
	// echo '<script src="'.URL::base().'assets/"></script>';
    
    echo  require "script.php";
    echo  require "script-init.php";
    echo  require "script-update-etat.php";
    echo  require "script-save.php";
    echo  require "script-versement_scolarite.php";

    $include_footer_script = ob_get_clean();

    $include_res_header =  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">';
    $include_res_header .=  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/loaders/loaders.min.css">';

?>
<?php


    $readonly = '';
    if(isset($_SESSION['DATA_TRANSPORT'])){
        //  var_dump($_SESSION['DATA_TRANSPORT']);
        
        $CODE_ELEVE = $_SESSION['DATA_TRANSPORT']['CODE_ELEVE'];
        $CODE_CLASSE = $_SESSION['DATA_TRANSPORT']['CODE_CLASSE'];
        $CODE_PARCOURS = $_SESSION['DATA_TRANSPORT']['CODE_PARCOURS'];

        // $MATRICULE = $_SESSION['DATA_TRANSPORT']['MATRICULE'];
        // $NOM = $_SESSION['DATA_TRANSPORT']['NOM'];
        // $PRENOM = $_SESSION['DATA_TRANSPORT']['PRENOM'];
        // $SEXE = $_SESSION['DATA_TRANSPORT']['SEXE'];
        // $DATE_NAISSANCE = $_SESSION['DATA_TRANSPORT']['DATE_NAISSANCE'];
        // $LIEU_NAISSANCE = $_SESSION['DATA_TRANSPORT']['LIEU_NAISSANCE'];
    }

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
                                
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="card-text">
                                        <p class="text-warning font-medium-3"><strong>Renseigner toutes les informations concernant le versement.</strong></p>
                                        <p class="font-medium-2"><strong class="red">NB !!!</strong> Preciser l'année scolaire en cours ou, <a href="<?= URL::link('annee_scolaire');?>" class="alert-link">Creer une?</a></p>.
                                    </div>

                                </div>  
                                    
                                <div class="col-md-5">
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
                                                    <option value="<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
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

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="eleve_nom_complet" class="col-4 col-form-label">Nom Complet:</label>
                                                                                <div class="col-8">
                                                                                    <select id="eleve_nom_complet" class="select2 form-control" name="eleve_nom_complet" required>
                                                                                        <?php foreach($eleves as $item){?>
                                                                                                <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né ".$item['date_naissance']." à ".$item['lieu_naissance']; ?>" value="<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
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
                                                                                <label for="classe" class="col-4 col-form-label">Classe:</label>
                                                                                <div class="col-8">

                                                                                    <select id="classe" class="select2 form-control" name="classe" required>
                                                                                        <!-- <option value="-----------">---------------</option> -->
                                                                                        <?php foreach($classes as $item){?>
                                                                                                <option data-id="<?= $item['id']; ?>" value="<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
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
                                                                        <div class="col-md-12">
                                                                            <h4 class="form-section text-warning" align="">
                                                                               
                                                                            </h4>
                                                                        </div>
                                                                    </div>

                                                                        <?php $i = 0;
                                                                            foreach($type_pensions as $item){  ?>
                                                                                <div class="row">
                                                                                    <div class="col-2">
                                                                                        <fieldset class="mb-1">
                                                                                            <div class="form-group">
                                                                                                <h5>Etat</h5>
                                                                                                 <?php echo $this->session->has(S::DATA_TRANSPORT)?
                                                                                                '<input type="checkbox" onclick="return toogleState(this);" data-id="'.$item['id'].'"  class="switchBootstrap" id="COL1-'.$item['id'].'"  name="COL1-'.$item['id'].'" data-on-text="Payé" data-off-text="Non payé" checked/>':
                                                                                                '<input type="checkbox" onclick="return toogleState(this);" data-id="'.$item['id'].'"  class="switchBootstrap" id="COL1-'.$item['id'].'"  name="COL1-'.$item['id'].'" data-on-text="Payé" data-off-text="Non payé"/>';    
                                                                                                ?>
                                                                                        
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </div>

                                                                                    <div class="col-3 ">
                                                                                        <fieldset class="mb-1">
                                                                                            <h5>Type Pension</h5>
                                                                                            <div class="form-group">
                                                                                            <?php echo $this->session->has(S::DATA_TRANSPORT)?
                                                                                                '<input type="text" class="form-control " value="'.$item['libelle'].'"  id="COL2-'.$item['id'].'"  name="COL2-'.$item['id'].'"  placeholder=""  disabled/>':
                                                                                                '<input type="text" class="form-control " value="'.$item['libelle'].'"  id="COL2-'.$item['id'].'"  name="COL2-'.$item['id'].'"  placeholder="" />';    
                                                                                                ?>
                                                                                                
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </div>

                                                                                    <div id="TYPE-SELECT-<?= $item['id']; ?>" class="col-3">
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
                                                                                
                                                                                    <div id="TYPE-NUMBER-<?= $item['id']; ?>" class="col-3">
                                                                                        <fieldset class="mb-1">
                                                                                            <h5>Multiplicateur</h5>
                                                                                            <div class="form-group">
                                                                                                <input type="number" class="form-control " value="1"  id="NUMBER-COL3-<?= $item['id'];?>"  name="NUMBER-COL3-<?= $item['id'];?>"    placeholder="">
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </div> 



                                                                                    <div class="col-4">
                                                                                        <fieldset class="mb-1">
                                                                                            <h5>Recaputilatif</h5>
                                                                                            <div class="form-group">
                                                                                                <input type="text" class="form-control "  id="COL4-<?= $item['id'];?>" value="0"  name="COL4-<?= $item['id'];?>"   placeholder="" readonly/>
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                </div>
                                                                    <?php    }  ?>
                                                                      
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 class="form-section text-warning" align="">
                                                                               
                                                                            </h4>
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

                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="date_paiement" class="col-4 col-form-label">Date de versement&nbsp;:</label>
                                                                                <div class="col-8">
                                                                                    <input type="date" class="form-control" value="<?= date("Y-m-d");?>" id="date_paiement" name="date_paiement" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <h4 class="form-section text-warning" align="">
                                                                                <strong>Informations complémentaires</strong>
                                                                            </h4>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="reste" class="col-4 col-form-label">Reste à payer&nbsp;:</label>
                                                                                <div class="col-8">
                                                                                    <input value="0" type="number" class="form-control" id="reste" name="reste" />
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="reduction" class="col-4 col-form-label">Montant de réduction&nbsp;:</label>
                                                                                <div class="col-8">
                                                                                    <input placeholder="Renseigner le montant de la réduction" value="0" type="number" class="form-control" id="reduction" name="reduction" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="motif" class="col-4 col-form-label">Motif :</label>
                                                                                <div class="col-8">
                                                                                    <textarea placeholder="Renseigner le motif du versement" class="form-control" style="min-height: 100px; max-height: 100px;" id="motif" name="motif"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="autres" class="col-4 col-form-label">Autres détails:</label>
                                                                                <div class="col-8">
                                                                                    <textarea placeholder="Renseigner toutes autres informations sur ce versement" class="form-control" style="min-height: 100px; max-height: 100px;" id="autres" name="autres"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                
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
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label for="statut_apprenant" class="col-4 col-form-label">Statut Apprenant:</label>
                                                                                <div class="col-8">
                                                                                    <select id="statut_apprenant" class="select2 form-control" name="statut_apprenant" required>
                                                                                        <?php
                                                                                        foreach($statut_apprenants as $item) { 
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
                                                                        
                                                                    </div>
                
                                                                    <div class="row">
                                                                        <div class="col-md-6">
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
                </div>
            </section>

            
            <?php include "versement_scolarite_etat.php"; ?>


        </div>
    </div>
</div>

