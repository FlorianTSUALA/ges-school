


<?php 

use Core\Routing\URL;

?>



<div class="modal animated fadeInDownBig text-left" id="modal-personnel-classe" role="dialog" aria-labelledby="myModalLabel40" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel40">Affecter un enseignant à une salle de classe</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
  
  <form id="form-restitution" >

        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="discipline" > nom de l'enseignant :</label>
            </div>
            <div class="form-group col-md-9">
                <select id="nom_enseignant" style="width:100%" class="select2 emprunt form-control" name="multi_select[]" id="multi_select" style="width:100%;">
                    <option data-matricule="" data-id="" disabled value="">----------------------</option>
                    <?php foreach($eleves as $item){?>
                    <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né ".$item['date_naissance']." à ".$item['lieu_naissance']; ?>" value="RF-<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>


        <div class="form-group row">
        <div class="form-group col-md-3">
                <label for="discipline" > salle de classe :</label>
            </div>
            <div class="form-group col-md-9">
                <select id="salle_classe" style="width:100%" class="select2 emprunt form-control" name="multi_select[]" id="multi_select" style="width:100%;">
                    <option data-matricule="" data-id="" disabled value="">----------------------</option>
                    <?php foreach($eleves as $item){?>
                    <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né ".$item['date_naissance']." à ".$item['lieu_naissance']; ?>" value="RF-<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
                    <?php } ?>
                </select>
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