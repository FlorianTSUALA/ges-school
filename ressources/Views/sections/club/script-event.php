<script>


//Revoir le tag recapitulatif

let data = 'Bienvenue à la section dédiée aux versements scolaires'

<?php if (isset($data_inscriptpion)){?>
data = "<?= 'L\'élève '.$data_inscriptpion['nom_eleve'] . ' ' . $data_inscriptpion['prenom_eleve'] . ' a été inscrit avec success à l\année scolaire '. $data_inscriptpion['annee_scolaire'] .' !!! '?>"
<?php } ?>
$(document).ready(function(){ flash_msg(data) });



    var items = []
    var data_versement = { 'cantine': {}, 'active': {}, 'autre': {}, 'scolarite': {}, 'inscription': {}, }
    // var item = {"pension_classe_code": '', 'type_pension_code' : '', "multiplicateur": '', "recapitulatif": '', "montant": 0, "mensualite": 0, "est_mensuel": false};

    var cantines = {}
    cantines['remise'] = 0
    cantines['periode'] = 0
    cantines['type_pension'] = 0
    cantines['montant'] = 0
    cantines['recapitulatif'] = 0

    var autres = {}
    autres['remise'] = 0
    autres['type_pension'] = ''
    autres['montant'] = 0
    // autres['recapitulatif'] = 0

    var activites = {}
    activites['remise'] = 0
    activites['periode'] = 0
    activites['activites'] = 0
    // activites['type_pension'] = 0
    // activites['montant'] = 0
    // activites['recapitulatif'] = 0


    $(document).ready(function(){


            //TYPE SELECT
            var _text =  ' '
            $('#family-relation').on('select2:close', function () {
                let select = $(this)
                select.trigger('change')
                const _data = select.select2('data')
                console.log("Livre : ")
                console.log(_data)
                let text =  '<ul>'
                _text =  ' '
                for(let k = 0; k<_data.length; k++)
                {
                    console.log(_data[k].selected)
                    text += ' <li> ' + _data[k].text + ' </li>'
                    _text += ' ' + _data[k].text + ' '
                }

                console.log("Livre . ")
                console.log(text + " ||| Size = "+select.select2('data').length)

                text += '</ul>'
                _text += ' '

                $('#list-familyship').html(text)

            })

            $(document).on('click', '#btn-save-family-relation', function(e)
            {
                // $('#RFT-reduction').val(" Reduction : "+$('#RF-reduction').val())
                $('#montant').val(parseFloat($('#montant').val()) - parseFloat($('#RFT-reduction').val()))


                // $('#relation_familial_input').html(_text)
                // init();
            })

            var data_select_relation_ship = []
            //Sauvegarde permanente de la valeur à mettre à jour
            $(document).on('click', '#btn-open-modal-familyship', function(e)
            {
                $('#OLD-RF-reduction').val($('#RF-reduction').val())
                $('family-relation').select2('data')
            })

            //Restauration en cas de desistement
            $(document).on('click', '#btn-cancel-family-relation', function(e)
            {
                $('#RF-reduction').val($('#OLD-RF-reduction').val())
                $('family-relation').val(data_select_relation_ship)
            })

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
                   
                        // init()
                    })

                    //TYPE NUMBER
                    $('#NUMBER-COL3-<?= $item['id']; ?>').on('change paste keyup mouseup', function () {
                        if($('#NUMBER-COL3-<?= $item['id']; ?>').val() < 0)
                            $('#NUMBER-COL3-<?= $item['id']; ?>').val(0)
                        console.log($('#NUMBER-COL3-<?= $item['id']; ?>').val())
                        items[<?= $i; ?>]['multiplicateur'] = $('#NUMBER-COL3-<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['recapitulatif'] = $('#NUMBER-COL3-<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['reduction'] = $('#COL5-<?= $item['id'];?>').val()
                     
                        // init()
                    })

                    //TYPE NUMBER OF REMISE
                    $('#COL5-<?= $item['id']; ?>').on('change paste keyup mouseup', function () {
                        if($('#COL5-<?= $item['id']; ?>').val() < 0)
                            $('#COL5-<?= $item['id']; ?>').val(0)
                        items[<?= $i; ?>]['remise'] = $('#COL5-<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['reduction'] = $('#COL5-<?= $item['id'];?>').val()
                        // init()
                    })

            <?php } ?>

        // END---------------------------------------


        // BEGIN ACTIVITE---------------------------------------
            //COL2 ACTIVITE
            $('#SELECT-COL2-Activite').on('select2:close', function () {
                console.log('nous y sommes')
                let select = $(this)
                select.trigger('change')

                var data = JSON.parse( JSON.stringify(select.select2('data')))
                var liste_activite = [];
                data.forEach(function(element){
                    // console.log(element)
                    liste_activite.push({'id': element.id, 'value': element.text, 'montant': element.title})
                })

                console.log(liste_activite)
                activites['activites'] = liste_activite;
               
                // init()
            })

            //COL-3 TRANCH ESCOLARITE
            $('#SELECT-COL3-Activite').on('select2:close', function () {
                let select = $(this)
                select.trigger('change')

                var data = JSON.parse( JSON.stringify(select.select2('data')))
                var tranches = [];
                    data.forEach(function(element){
                    //console.log(element)
                    tranches.push({'id': element.id, 'value': element.text})
                })

                // console.log("#### "+tranches.length)
                console.log('Gloire à Dieu', tranches)

                activites['remise'] = $('#COL5-Activite').val()

                activites['multiplicateur'] = tranches;
                activites['recapitulatif'] = tranches.length;
                // init()
            })

            //COL5 Activite

            
            $('#COL5-Activite').on('change paste keyup mouseup', function () {
                if($('#COL5-Activite').val() < 0)
                    $('#COL5-Activite').val(0)
                activites['remise'] = $('#COL5-Activite').val()
                // init()
            })
        // END---------------------------------------

        // BEGIN CANTINE---------------------------------------
            //COL5 Cantine
            $('#COL5-Cantine').on('change paste keyup mouseup', function () {
                if($('#COL5-Cantine').val() < 0)
                    $('#COL5-Cantine').val(0)
                cantines['remise'] = $('#COL5-Cantine').val()
                // init()
            })

            //COL 3 Cantine
            $('#SELECT-COL3-Cantine').on('select2:close', function () {
                let select = $(this)
                select.trigger('change')

                var data = JSON.parse( JSON.stringify(select.select2('data')))
                var tranches = [];
                data.forEach(function(element){
                    //console.log(element)
                    tranches.push({'id': element.id, 'value': element.text})
                })

                cantines['multiplicateur'] = select.select2('data').length;
                cantines['recapitulatif'] = tranches;
                // init()
            })
        // END---------------------------------------

        // BEGIN AUTRE---------------------------------------
            //COL2
            //COL 3 Autres
            $('#NUMBER-COL3-Autres').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() < 0)
                    current.val(0)
                console.log(current.val())
                autres['montant'] = current.val()
                // init()
            })

            //COL5 Autre
            $('#COL5-Autres').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() < 0)
                    current.val(0)
                autres['remise'] = current.val()
                // init()
            })
            //COL2 Autre
            $('#COL2-Autres').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() == '')
                    autres['type_pension'] = ''
                autres['type_pension'] = current.val()
            })
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


        //AUtres

        //Cantine

        //Activite
    }

</script>