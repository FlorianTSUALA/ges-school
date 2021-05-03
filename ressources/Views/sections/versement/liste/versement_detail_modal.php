<?php 

use Core\Routing\URL;

?>


<div class="modal animated fadeInDownBig text-left" id="modal-restitution" role="dialog" aria-labelledby="myModalLabel40" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel40">Restitution du livre</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
  
  <form id="form-restitution" >

        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="discipline" > Nom :</label>
            </div>
            <div class="form-group col-md-10">
                <select id="restitution" style="width:100%" class="select2 restitution form-control" name="multi_select[]" id="multi_select" style="width:100%;" disabled>
                    <option data-matricule="" data-id="" disabled value="">----------------------</option>
                    <?php foreach($eleves as $item){?>
                    <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né ".$item['date_naissance']." à ".$item['lieu_naissance']; ?>" value="RF-<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>


        <div class="form-group row">
            <div class="form-group col-3">
                    <label for="code-livre">Code d'enregistrement</label>
                    <select class="select2 code-livre form-control" style="width: 100%;" name="code_livre" id="code-livre" disabled>
                        <?php foreach($exemplaire_disponibles as $item){?>
                        <option  data-id="<?= $item['document_id']; ?>" title="<?= $item['document'] ?>" value="<?= $item['exemplaire_id']; ?>"><?= $item['code_enregistrement']; ?></option>
                        <?php } ?>
                    </select>
            </div>
            <div class="form-group col-6">
                <label for="titre-livre">Titre </label>
                <select class="select2 titre-livre form-control" style="width: 100%;" name="titre_livre" id="titre-livre" disabled>
                    <?php foreach($exemplaire_disponibles as $item){?>
                    <option  data-id="<?= $item['document_id']; ?>" title="<?= $item['document'] ?>" value="<?= $item['exemplaire_id']; ?>"><?= $item['document']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-3">
                    <label for="etat-livre">Etat d'entretien </label>
                    <select class="select2 etat-livre form-control" style="width: 100%;" name="etat_livre" id="etat-livre">
                        <?php foreach($etat_documents as $item){?>
                        <option  data-id="<?= $item['etat_document_id']; ?>" title="<?= $item['etat_document'] ?>" value="<?= $item['etat_document_id']; ?>"><?= $item['etat_document']; ?></option>
                        <?php } ?>
                    </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group col-md-2">
                <label for="commentaire" > Commentaire :</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" name="commentaire" id="commentaire">
            </div>
           
        </div>

        <div class="text-muted font-small-2" >Etat du document à la restitution</div>

        <hr> 
        <div class="row pb-0 pt-1 mb-0 mt-1">

        
            <div class="col my-0 py-0">
                <div class="form-group row">
                    <label for="date_restitution" class="col-4 col-form-label">Date de retour prévu&nbsp;:</label>
                    <div class="col-8">
                        <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="date_restitution" name="date_restitution" disabled/>
                    </div>
                </div>
            </div>


            <div class="col my-0 py-0">
                <div class="form-group row">
                    <label for="date_retour" class="col-4 col-form-label">Date de retour effective&nbsp;:</label>
                    <div class="col-8">
                        <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="date_retour" name="date_retour"  />
                    </div>
                </div>
            </div>

        </div>

      <div class="form-actions right">
        <button type="reset"id="modal-restitution-delete" type="button" data-dismiss="modal" class="btn btn-warning mr-1">
          <i class="ft-x"></i> Annuler
        </button>
        <button type="submit" id="modal-restitution-save" class="btn btn-primary">
          <i class="fa fa-check-square-o"></i> Enregistrer
        </button>
      </div>
  
  </form>

</div>
            
              
        </div>
    </div>
</div>