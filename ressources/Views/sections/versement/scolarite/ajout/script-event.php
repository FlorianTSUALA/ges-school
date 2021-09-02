<script>

    $(document).ready(function(){

        // BEGIN REL FAMI
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
        // END REL FAMI

        // BEGIN AUTRE---------------------------------------
            $('#COL_MONTANT_AUTRES').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() < 0)
                    current.val(0)
                autres['montant'] = current.val()
                updateAutre(current.val())
            })

            $('#COL_REDUCTION_AUTRES').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() < 0)
                    current.val(0)
                autres['reduction'] = current.val()
                updateAutre(undefined, current.val())
            })

            $('#COL_LIBELLE_AUTRES').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() == '')
                    autres['type_pension'] = ''
                updateAutre(undefined, undefined, current.val())
            })
        // END---------------------------------------

        // BEGIN SCOLARITE---------------------------------------
            $('#COL_REDUCTION_SCOLARITE').on('change paste keyup mouseup', function () {
                let current = $(this)
                if(current.val() < 0)
                    current.val(0)
                updateScolarite(undefined, current.val())
            })
        // END---------------------------------------

    })


    //  MET A JOUR LE TYPE DE MULTIPLICATEUR QD LA VALEUR DE LA CLASSE CHANGE (HIDE/SHOW)
    function trigger_classe(classe_id){
        item = get_item_by_item_key('classe_id', classe_id, prix_scolarite_tranche_classe)
        $('#COL_TRANCHE_SCOLARITE').val(null)
        $('#COL_TRANCHE_SCOLARITE').empty()
        item.pension_scolaire.forEach(function(subitem){
            var data = {
                id: subitem.code,
                text: subitem.tranche_scolaire_libelle
            }               
            var new_option = new Option(data.text, data.id, false, false);
            $('#COL_TRANCHE_SCOLARITE').append(new_option)
        })

        $('#COL_TRANCHE_SCOLARITE').trigger('change');
        $('#COL_REDUCTION_SCOLARITE').val(0)
        $('#COL_RECAPITULATIF_SCOLARITE').val(0)
    }


    function trigger_tranche(tranche, classe_id){
        item = get_item_by_item_key('classe_id', classe_id, prix_scolarite_tranche_classe)

        let montant = 0

        for(let sub_item of tranche) 
            for(let k of item['pension_scolaire'])
                if(sub_item['id'] == k['code'])
                    montant += parseFloat(k['montant'])
            
        updateScolarite(montant)

        $('#COL_MONTANT_SCOLARITE').val(montant)
        $('#COL_REDUCTION_SCOLARITE').val(0)
        $('#COL_RECAPITULATIF_SCOLARITE').val(montant)
    }

    function get_item_by_item_key($tag, $tag_value, $array){
        for(let item of $array)
            if(item[$tag] == $tag_value)
                return item
    }
    
    function updateScolarite(montant, reduction, libelle="SCOLARITE"){
        scolarites['libelle'] = libelle 
        scolarites['reduction'] = (reduction === undefined)? scolarites['reduction'] : reduction 
        scolarites['montant'] = (montant === undefined)? scolarites['montant'] : montant 
        scolarites['recapitulatif'] = scolarites['montant'] - scolarites['reduction']
        $('#COL_RECAPITULATIF_SCOLARITE').val(scolarites['recapitulatif'])
        init()
    }
    
    function updateAutre(montant, reduction, libelle=""){
        autres['libelle'] = libelle 
        autres['reduction'] = (reduction === undefined)? autres['reduction'] : reduction  
        autres['montant'] = (montant === undefined)? autres['montant'] : montant 
        autres['recapitulatif'] = autres['montant'] - autres['reduction']
        $('#COL_RECAPITULATIF_AUTRE').val(autres['recapitulatif'])
        init()
    }

</script>