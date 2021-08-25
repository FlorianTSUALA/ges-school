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


</script>