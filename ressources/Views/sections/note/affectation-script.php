<?php

use App\Helpers\Helpers;

?>


<script>

    <?php Helpers::jsResponsibleSelect2JsGrid() ?>

    var $jsGridData = []
   
    var $data_master = <?= Helpers::toJSON($data_all) ?>;

    console.log($data_master['SECTION_1']);

    <?php foreach($data_salle_classes as $item){ ?>
        //<---x
        $jsGridData['<?= $item['salle_classe_code'] ?>'] = [];
        $jsGridData['<?= $item['salle_classe_code'] ?>']['eleves'] = [];
        $jsGridData['<?= $item['salle_classe_code'] ?>']['matieres'] = [];

    <?php } ?>
    
    <?php foreach($data_all as $data_classe){ ?>
        
        <?php foreach($data_classe['salle_classes'] as $data_salle){ ?>
      
    //--        
    var $data_master = <?= Helpers::toJSON($data_salle['eleves']) ?>;
               
            <?php foreach($data_salle['eleves'] as $data_eleve){ ?>
        
            <?php } ?>


        <?php } ?>

        <?php 
            $matieres = $data_classe['matieres'];
        ?>
        
    <?php } ?>
    
    // http://js-grid.com/docs/#controller
    var table = $("#table_affectation_personnel_salle_classe")

   
</script>



<script>
// $('#menu .list-group a.list-group-item').first().addClass('active')
// $('#menu .list-group a.list-group-item').click(function(e) {
//   $('#menu .list-group a.list-group-item.active').removeClass('active');
//   var $current = $(this)
//   $current.addClass('active');
//   e.preventDefault();
//   if(this.id.includes('ID_')){
//     classe_id = this.id.replace('ID_', '')
//   }
//   table.jsGrid("loadData", { classe: classe_id})
//   console.log(classe_id)
// });

</script>