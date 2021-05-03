<script>
    var items = [];
    $(document).ready(function(){
        
        // var item = { "state" : '', "pension_classe_code": '', "type_pension_code" : '', "multiplicateur": '', "recapitulatif": "", "montant": 0, "mensualite": 0, "est_mensuel": false};

        //INITILISATION DU TABLEAU
        <?php  $i = -1; 
            foreach($type_pensions as $item){ $i++; ?>  
                let <?= "item".$i; ?> = { "state" : false, "pension_classe_code": '',"type_pension_code" : '<?= $item['id'];?>', "type_pension" : '<?= $item['libelle'];?>', "multiplicateur": 0, "recapitulatif": '', "montant": 0, "mensualite": 0, "est_mensuel": false};
                items.push(<?= "item".$i; ?>);
        <?php } ?>
        console.log("items : ");
        console.log(items);
            
        //ACTIVATION OU NON DE LA LIGNE
        <?php    $i = -1;
            foreach($type_pensions as $item){ $i++; ?>  
                $('input#COL1-<?= $item['id'];?>').on('switchChange.bootstrapSwitch', function (event, state){
                    let code = event.target.getAttribute('data-id');
                    items[<?= $i; ?>]['state'] = state;
                    $('#NUMBER-COL3-'+code).prop('disabled', !state);
                    $('#SELECT-COL3-'+code).prop('disabled', !state);
                    console.log("State : "+state);
                    init();
                });
        <?php } ?>

        //DECLECHEUR DES SELECTEURS DES MOIS OU D'UNITÉ
        //HANDLEUR MULTIPLICATEUR CHANGE
        <?php $i = -1;
            foreach($type_pensions as $item){ $i++; ?>   
                //TYPE SELECT
                $('#SELECT-COL3-<?= $item['id']; ?>').on("select2:select select2:unselecting", function () {
                    $('#SELECT-COL3-<?= $item['id']; ?>').select2('data');
                    let elements = JSON.parse( JSON.stringify($('#SELECT-COL3-<?= $item['id']; ?>').select2('data')));
                    let tranches = [];
                    elements.forEach(function(element){
                        tranches.push({'id': element.id, 'value': element.text});
                    });
                    
                    items[<?= $i; ?>]['multiplicateur'] = tranches;
                    items[<?= $i; ?>]['recapitulatif'] = tranches.length;
                    console.log("Taille");
                    console.log(tranches.length);
                    init();
                });

                //TYPE NUMBER
                $('#NUMBER-COL3-<?= $item['id']; ?>').on("change paste keyup mouseup", function () {
                    if($('#NUMBER-COL3-<?= $item['id']; ?>').val() < 0)
                        $('#NUMBER-COL3-<?= $item['id']; ?>').val(1);
                    console.log($('#NUMBER-COL3-<?= $item['id']; ?>').val());
                    items[<?= $i; ?>]['multiplicateur'] = $('#NUMBER-COL3-<?= $item['id']; ?>').val();
                    items[<?= $i; ?>]['recapitulatif'] = $('#NUMBER-COL3-<?= $item['id']; ?>').val();
                    // console.log("NUMBER ");
                    // console.log($('#NUMBER-COL3-<?= $item['id']; ?>').val());
                    init();
                });

        <?php } ?>
    });

    //INITIALISATION DU MULTIPLICATEUR
    // function init(){}

    //  MET A JOUR LE TYPE DE MULTIPLICATEUR QD LA VALEUR DE LA CLASSE CHANGE (HIDE/SHOW)
    function trigger(classe_id){
        let type_pension_classe = <?= $pension_classe; ?>;
        //Initilisation
        <?php   $i = -1;
            foreach($type_pensions as $type_pension_id){  $i++; ?>
                let <?= "active_type_$i"; ?> = '#TYPE-NUMBER-<?= $type_pension_id['id']; ?>';     
                let <?= "inactive_type_$i"; ?> = '#TYPE-SELECT-<?= $type_pension_id['id']; ?>';
                // console.log("<?= $i; ?>");
                type_pension_classe.forEach(function(item){
                         
                    if(item.type_pension == '<?= $type_pension_id['id']; ?>' && item.classe == classe_id){
                        // console.log(item);
                        items[<?= $i; ?>]['pension_classe_code'] = item.id;
                        items[<?= $i; ?>]['montant'] = item.montant;
                        items[<?= $i; ?>]['mensualite'] = item.mensualite;
                        items[<?= $i; ?>]['est_mensuel'] = item.est_mensuel;
                        // console.log(" !=!- -> montant : "+ item.montant);
                        // console.log(" !=!- -> mensualite : "+ item.mensualite);
                        // console.log(" !=!- -> est_mensuel : "+ item.est_mensuel);
                        
                        if(parseInt(item.est_mensuel) == 1){
                            // console.log("<?= $type_pension_id['libelle']; ?>");
                            // console.log(item.est_mensuel);
                            <?= "active_type_$i"; ?> = '#TYPE-SELECT-<?= $type_pension_id['id']; ?>';
                            <?= "inactive_type_$i"; ?> = '#TYPE-NUMBER-<?= $type_pension_id['id']; ?>';
                        }else{
                            <?= "active_type_$i"; ?> = '#TYPE-NUMBER-<?= $type_pension_id['id']; ?>';
                            <?= "inactive_type_$i"; ?> = '#TYPE-SELECT-<?= $type_pension_id['id']; ?>';
                        }
                        
                        return item;
                    }

                });

                $(<?= "active_type_$i"; ?>).show();
                $(<?= "inactive_type_$i"; ?>).hide();

        <?php } ?>

    }
</script>