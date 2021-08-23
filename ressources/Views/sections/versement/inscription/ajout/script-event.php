<script>


//Revoir le tag recapitulatif

let data = 'Bienvenue à la section dédiée aux versements scolaires'

$(document).ready(function(){ flash_msg(data) });



    var items = []
    var data_versement = {'inscription': {}, }

    $(document).ready(function(){

        // BEGIN AUTO---------------------------------------
            //INITILISATION DU TABLEAU PINFO PENSION
            <?php  $i = -1;
                foreach($type_pensions as $item){ $i++; ?>
                    let <?= "item".$i; ?> = {"pension_classe_code": '','type_pension_code' : '<?= $item['id'];?>', "type_pension" : '<?= $item['libelle'];?>', "multiplicateur": 0, "recapitulatif": '', "montant": 0, "remise": 0, "mensualite": 0, "est_mensuel": false};
                    items.push(<?= "item".$i; ?>)
            <?php } ?>
            console.log("items : ")
            console.log(items)


            //DECLECHEUR DES SELECTEURS DES MOIS OU D'UNITÉ
            //HANDLEUR MULTIPLICATEUR CHANGE

            <?php $i = -1;
                foreach($type_pensions as $item){ $i++; ?>
                    //TYPE SELECT
                    $('#SELECT-COL3-<?= $item['id']; ?>').on('select2:close', function () {
                   
                        let select = $(this)
                      
                        select.trigger('change')

                        var data = JSON.parse( JSON.stringify(select.select2('data')))
                        var tranches = [];
                        data.forEach(function(element){
                            // console.log(element)
                            tranches.push({'id': element.id, 'value': element.text})
                        })

                        items[<?= $i; ?>]['multiplicateur'] = tranches;
                        items[<?= $i; ?>]['recapitulatif'] = select.select2('data').length;

                        items[<?= $i; ?>]['reduction'] = $('#COL5-<?= $item['id'];?>').val()
                   
                        init()
                    })

                    //TYPE NUMBER
                    $('#NUMBER-COL3-<?= $item['id']; ?>').on('change paste keyup mouseup', function () {
                        if($('#NUMBER-COL3-<?= $item['id']; ?>').val() < 0)
                            $('#NUMBER-COL3-<?= $item['id']; ?>').val(0)
                        console.log($('#NUMBER-COL3-<?= $item['id']; ?>').val())
                        items[<?= $i; ?>]['multiplicateur'] = $('#NUMBER-COL3-<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['recapitulatif'] = $('#NUMBER-COL3-<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['reduction'] = $('#COL5-<?= $item['id'];?>').val()
                     
                        init()
                    })

                    //TYPE NUMBER OF REMISE
                    $('#COL5-<?= $item['id']; ?>').on('change paste keyup mouseup', function () {
                        if($('#COL5-<?= $item['id']; ?>').val() < 0)
                            $('#COL5-<?= $item['id']; ?>').val(0)
                        items[<?= $i; ?>]['remise'] = $('#COL5-<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['reduction'] = $('#COL5-<?= $item['id'];?>').val()
                        init()
                    })

            <?php } ?>

        // END---------------------------------------


    })

    //INITIALISATION DU MULTIPLICATEUR

    //  MET A JOUR LE TYPE DE MULTIPLICATEUR QD LA VALEUR DE LA CLASSE CHANGE (HIDE/SHOW)
    //ToogleVisibleMultiplicator
    function trigger(classe_id){
        let type_pension_classe = <?= $pension_classe; ?>
        //Initilisation
        <?php   $i = -1;
            foreach($type_pensions as $type_pension){  $i++; ?>
                let <?= "active_type_$i"; ?> = '#TYPE-NUMBER-<?= $type_pension['id']; ?>'
                let <?= "inactive_type_$i"; ?> = '#TYPE-SELECT-<?= $type_pension['id']; ?>'

                type_pension_classe.forEach(function(item){

                    if(item.type_pension == '<?= $type_pension['id']; ?>' && item.classe == classe_id){
                        
                        items[<?= $i; ?>]['pension_classe_code'] = item.id;
                        items[<?= $i; ?>]['montant'] = item.montant;
                        items[<?= $i; ?>]['remise'] = item.remise;
                        items[<?= $i; ?>]['mensualite'] = item.mensualite;
                        items[<?= $i; ?>]['est_mensuel'] = item.est_mensuel;
                        

                        if(parseInt(item.est_mensuel) == 1){
                            <?= "active_type_$i"; ?> = '#TYPE-SELECT-<?= $type_pension['id']; ?>'
                            <?= "inactive_type_$i"; ?> = '#TYPE-NUMBER-<?= $type_pension['id']; ?>'
                        }else{
                            <?= "active_type_$i"; ?> = '#TYPE-NUMBER-<?= $type_pension['id']; ?>'
                            <?= "inactive_type_$i"; ?> = '#TYPE-SELECT-<?= $type_pension['id']; ?>'
                        }

                        return item;
                    }

                })

                $(<?= "active_type_$i"; ?>).show()
                $(<?= "inactive_type_$i"; ?>).hide()

        <?php } ?>

    }

</script>