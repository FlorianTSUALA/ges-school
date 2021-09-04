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
    cantines['reduction'] = 0
    cantines['periode'] = 0
    cantines['type_pension'] = 0
    cantines['montant'] = 0
    cantines['montant_net'] = 0

    var autres = {}
    autres['reduction'] = 0
    autres['type_pension'] = ''
    autres['montant'] = 0
    // autres['montant_net'] = 0

    var activites = {}
    activites['reduction'] = 0
    activites['periode'] = 0
    activites['activites'] = 0
    // activites['type_pension'] = 0
    // activites['montant'] = 0
    // activites['montant_net'] = 0


    $(document).ready(function(){


            //TYPE SELECT
            var _text =  ' '
            $('#family-relation').on('select2:close', function () {
                let select = $(this)
                select.trigger('change')
                const _data = select.select2('data')
                console.log("Livre : ")

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
                $('#RFT-reduction').val(" Reduction : "+$('#RF-reduction').val())
                $('#montant').val(parseFloat($('#montant').val()) - parseFloat($('#RFT-reduction').val()))
                $('#relation_familial_input').html(_text)
                console.log(_text);
                init();
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
                    $('#COL_TRANCHE_SELECT_<?= $item['id']; ?>').on('select2:close', function () {
                   
                        let select = $(this)
                      
                        select.trigger('change')

                        var data = JSON.parse( JSON.stringify(select.select2('data')))
                        var tranches = [];
                        data.forEach(function(element){
                            // console.log(element)
                            tranches.push({'id': element.id, 'value': element.text})
                        })

                        items[<?= $i; ?>]['multiplicateur'] = tranches;
                        items[<?= $i; ?>]['montant_net'] = select.select2('data').length;

                        items[<?= $i; ?>]['reduction'] = $('#COL_REDUCTION_<?= $item['id'];?>').val()
                   
                        init()
                    })

                    //TYPE NUMBER
                    $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').on('change paste keyup mouseup', function () {
                        if($('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val() < 0)
                            $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val(0)
                        console.log($('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val())
                        items[<?= $i; ?>]['multiplicateur'] = $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['montant_net'] = $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['reduction'] = $('#COL_REDUCTION_<?= $item['id'];?>').val()
                     
                        init()
                    })

                    //TYPE NUMBER OF REMISE
                    $('#COL_REDUCTION_<?= $item['id']; ?>').on('change paste keyup mouseup', function () {
                        if($('#COL_REDUCTION_<?= $item['id']; ?>').val() < 0)
                            $('#COL_REDUCTION_<?= $item['id']; ?>').val(0)
                        items[<?= $i; ?>]['reduction'] = $('#COL_REDUCTION_<?= $item['id']; ?>').val()
                        items[<?= $i; ?>]['reduction'] = $('#COL_REDUCTION_<?= $item['id'];?>').val()
                        init()
                    })

            <?php } ?>

        // END---------------------------------------


        // BEGIN ACTIVITE---------------------------------------
            //COL2 ACTIVITE
            $('#COL_SELECT_LIBELLE_ACTIVITE').on('select2:close', function () {
                let select = $(this)
                select.trigger('change')

                var data = JSON.parse( JSON.stringify(select.select2('data')))
                var liste_activite = [];
                data.forEach(function(element){
                    // console.log(element)
                    liste_activite.push({'id': element.id, 'value': element.text, 'montant': element.title})
                })

                activites['activites'] = liste_activite;
               
                init()
            })

            //COL-3 TRANCH ESCOLARITE
            $('#COL_TRANCHE_SELECT_ACTIVITE').on('select2:close', function () {
                let select = $(this)
                select.trigger('change')

                var data = JSON.parse( JSON.stringify(select.select2('data')))
                var tranches = [];
                    data.forEach(function(element){
                    //console.log(element)
                    tranches.push({'id': element.id, 'value': element.text})
                })

                console.log("#### "+tranches.length)

                activites['reduction'] = $('#COL_REDUCTION_ACTIVITE').val()

                activites['multiplicateur'] = tranches;
                activites['montant_net'] = tranches.length;
                init()
            })

            //COL5 Activite

            
            $('#COL_REDUCTION_ACTIVITE').on('change paste keyup mouseup', function () {
                if($('#COL_REDUCTION_ACTIVITE').val() < 0)
                    $('#COL_REDUCTION_ACTIVITE').val(0)
                activites['reduction'] = $('#COL_REDUCTION_ACTIVITE').val()
                init()
            })
        // END---------------------------------------

        // BEGIN CANTINE---------------------------------------
            //COL5 Cantine
            $('#COL_REDUCTION_CANTINE').on('change paste keyup mouseup', function () {
                if($('#COL_REDUCTION_CANTINE').val() < 0)
                    $('#COL_REDUCTION_CANTINE').val(0)
                cantines['reduction'] = $('#COL_REDUCTION_CANTINE').val()
                init()
            })

            //COL 3 Cantine
            $('#COL_TRANCHE_SELECT_CANTINE').on('select2:close', function () {
                let select = $(this)
                select.trigger('change')

                var data = JSON.parse( JSON.stringify(select.select2('data')))
                var tranches = [];
                data.forEach(function(element){
                    //console.log(element)
                    tranches.push({'id': element.id, 'value': element.text})
                })

                cantines['multiplicateur'] = select.select2('data').length;
                cantines['montant_net'] = tranches;
                init()
            })
        // END---------------------------------------

        // BEGIN AUTRE---------------------------------------
            //COL2
            //COL 3 Autres
            $('#COL_MONTANT_AUTRES').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() < 0)
                    current.val(0)
                console.log(current.val())
                autres['montant'] = current.val()
                init()
            })

            //COL5 Autre
            $('#COL_REDUCTION_AUTRES').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() < 0)
                    current.val(0)
                autres['reduction'] = current.val()
                init()
            })
            //COL2 Autre
            $('#COL_LIBELLE_AUTRES').on('change paste keyup mouseup', function () {
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
                let <?= "active_type_$i"; ?> = '#TYPE_NUMBER_<?= $type_pension['id']; ?>'
                let <?= "inactive_type_$i"; ?> = '#TYPE_SELECT_<?= $type_pension['id']; ?>'

                type_pension_classe.forEach(function(item){

                    if(item.type_pension == '<?= $type_pension['id']; ?>' && item.classe == classe_id){
                        
                        items[<?= $i; ?>]['pension_classe_code'] = item.id;
                        items[<?= $i; ?>]['montant'] = item.montant;
                        items[<?= $i; ?>]['reduction'] = item.remise;
                        items[<?= $i; ?>]['mensualite'] = item.mensualite;
                        items[<?= $i; ?>]['est_mensuel'] = item.est_mensuel;
                        

                        if(parseInt(item.est_mensuel) == 1){
                            <?= "active_type_$i"; ?> = '#TYPE_SELECT_<?= $type_pension['id']; ?>'
                            <?= "inactive_type_$i"; ?> = '#TYPE_NUMBER_<?= $type_pension['id']; ?>'
                        }else{
                            <?= "active_type_$i"; ?> = '#TYPE_NUMBER_<?= $type_pension['id']; ?>'
                            <?= "inactive_type_$i"; ?> = '#TYPE_SELECT_<?= $type_pension['id']; ?>'
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