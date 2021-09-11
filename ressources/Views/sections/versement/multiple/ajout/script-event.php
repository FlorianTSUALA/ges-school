<?php

use App\Helpers\S;
use App\Model\Technique\E;
use App\Model\TypePension;

?>

<script>
    //Revoir le tag recapitulatif

    let data = 'Bienvenue à la section dédiée aux versements scolaires'

    <?php if (isset($data_inscriptpion)) { ?>
        data = "<?= 'L\'élève ' . $data_inscriptpion[S::VERS_NOM] . ' ' . $data_inscriptpion[S::VERS_PRENOM] . ' a été bien enregistré comme Veuillez l\'inscrire pour le compte de l\'année scolaire ' . $this->session->get(S::ANNEE_SCOLAIRE_LIBELLE) . ' !!! ' ?>"
    <?php } ?>


    $(document).ready(function() {
        flash_msg(data)
    });


    var groupe_familial = {
        'famille' : '', 
        'membres' : [],
        'reduction' : 0
    }
    var items = {}
    var data_versement = {
        'cantine': {},
        'activite': {},
        'autre': {},
        'scolarite': {},
        'inscription': {},
    }
    // var item = {"pension_classe_code": '', 'type_pension_code' : '', "multiplicateur": '', "recapitulatif": '', "montant": 0, "mensualite": 0, "paiement_en_tranche": false};

    var cantines = {}
    cantines['reduction'] = 0
    cantines['periode'] = 0
    cantines['type_pension'] = 0
    cantines['montant'] = 0
    cantines['montant_net'] = 0
    cantines['montant_brut'] = 0

    var autres = {}
    autres['reduction'] = 0
    autres['libelle'] = ''
    autres['montant'] = 0
    autres['montant_net'] = 0
    autres['montant_brut'] = 0

    var activites = {}
    activites['reduction'] = 0
    activites['periode'] = 0
    activites['liste'] = []
    activites['multiplicateur'] = 0
    // activites['type_pension'] = 0
    activites['montant'] = 0
    activites['montant_net'] = 0
    activites['montant_brut'] = 0


    $(document).ready(function() {

        //TYPE SELECT
        var _text = ' '
        $('#family-relation').on('select2:close', function() {
            let select = $(this)
            select.trigger('change')
            const _data = select.select2('data')
            console.log("Livre : ")

            let text = '<ul>'
            _text = ' '
            for (let k = 0; k < _data.length; k++) {
                console.log(_data[k].selected)
                text += ' <li> ' + _data[k].text + ' </li>'
                _text += ' ' + _data[k].text + ' '
            }

            console.log("Livre . ")
            console.log(text + " ||| Size = " + select.select2('data').length)

            text += '</ul>'
            _text += ' '

            $('#list-familyship').html(text)

        })

        // $('#famille').on('change paste keyup mouseup', function() {
        //     if ($('#famille').val().length > 0)
        //         $('#famille').val($('#old-famille').val())
        //         groupe_familial.famille = $('#famille').val()
        //     init()
            
        // })

        $(document).on('click', '#btn-save-family-relation', function(e) {
            $('#RFT-reduction').val(" Reduction : " + $('#RF-reduction').val())
            $('#montant').val(parseFloat($('#montant').val()) - parseFloat($('#RFT-reduction').val()))
            $('#relation_familial_input').html(_text)

            //if ($('#famille').val().length > 0)
            // $('#famille').val($('#old-famille').val())
            groupe_familial.famille = $('#famille').val()
            groupe_familial.reduction = $('#RF-reduction').val()
            groupe_familial.membres = $('#family-relation').val()

            console.log(_text);
            console.log(groupe_familial);
            init();
        })

        var data_select_relation_ship = []
        //Sauvegarde permanente de la valeur à mettre à jour
        $(document).on('click', '#btn-open-modal-familyship', function(e) {
            $('#OLD-RF-reduction').val($('#RF-reduction').val())
            $('#old-famille').val($('#famille').val())
            $('family-relation').select2('data')
        })

        //Restauration en cas de desistement
        $(document).on('click', '#btn-cancel-family-relation', function(e) {
            $('#RF-reduction').val($('#OLD-RF-reduction').val())
            $('#famille').val($('#old-famille').val())
            $('family-relation').val(data_select_relation_ship)
        })

        // BEGIN AUTO---------------------------------------
        //INITILISATION DU TABLEAU PINFO PENSION
        <?php
        foreach ($type_pensions as $item) { ?>
            items['<?= $item['id'] ?>'] = {
                "pension_classe_code": '',
                'type_pension_code': '<?= $item['id']; ?>',
                "type_pension": '<?= $item['libelle']; ?>',
                "multiplicateur": 0,
                "recapitulatif": '',
                "montant_net": 0,
                "montant_brut": 0,
                "montant": 0,
                "remise": 0,
                "liste": [],
                "tranche": [],
                // "mensualite": 0,
                "paiement_en_tranche": false
            };
        <?php } ?>
        console.log("items : ")
        console.log(items)


        //DECLECHEUR DES SELECTEURS DES MOIS OU D'UNITÉ
        //HANDLEUR MULTIPLICATEUR CHANGE

        <?php
        foreach ($type_pensions as $item) { ?>
            //TYPE SELECT
            <?php if ($item['id'] == TypePension::INSCRIPTION_CODE) { ?>
                //TYPE NUMBER
                $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val(1)
                $('#COL_REDUCTION_<?= $item['id']; ?>').val(0)
                items['<?= $item['id'] ?>']['paiement_en_tranche'] = '<?= E::NON ?>';
                $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').on('change paste keyup mouseup', function() {
                    if ($('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val() < 0)
                        $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val(0)
                    console.log($('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val())
                    

                    items['<?= $item['id'] ?>']['multiplicateur'] = $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val()
                    items['<?= $item['id'] ?>']['reduction'] = $('#COL_REDUCTION_<?= $item['id']; ?>').val()
                    items['<?= $item['id'] ?>']['montant_brut'] = items['<?= $item['id'] ?>']['multiplicateur'] * items['<?= $item['id'] ?>']['montant']
                    items['<?= $item['id'] ?>']['montant_net'] = items['<?= $item['id'] ?>']['montant_brut'] - items['<?= $item['id'] ?>']['reduction']
                    $('#COL_RECAPITULATIF_<?= $item['id'] ?>' ).val(items['<?= $item['id'] ?>']['montant_net'])
                   
                    console.log(items['<?= $item['id'] ?>']['montant_net'])
                    init()
                    console.log(items['<?= $item['id'] ?>'])

                })
            <?php } else { ?>
                <?php if ($item[E::PAIEMENT_EN_TRANCHE] == E::OUI) { ?>
                    console.log(items)
                    items['<?= $item['id'] ?>']['paiement_en_tranche'] = '<?= E::OUI ?>';
                    $('#COL_TRANCHE_SELECT_<?= $item['id']; ?>').on('select2:close', function() {

                        let select = $(this)
                        select.trigger('change')
                        var data = JSON.parse(JSON.stringify(select.select2('data')))
                        var tranches = [];
                        let _total = 0;
                        data.forEach(function(element) {
                            let classe_id = $(classe).select2().find(":selected").data("id")
                            let type_pension_code = element.id
                            data = pension_classe['' + classe_id].type_pension['<?= $item['id']; ?>'].tranche_info
                            for (k of data) {
                                if (k.tranche_scolaire_code === element.id) {

                                    tranches.push({
                                        'tranche_scolaire_code': k.tranche_scolaire_code,
                                        'pension_classe_id': k.id,
                                        'value': element.text,
                                        'montant': k.montant,
                                        'pension_classe_code': k.id
                                    })
                                    _total += parseFloat(k.montant)
                                    break;
                                }
                            }
                        })
                        console.log("##RESERVE##")

                        items['<?= $item['id'] ?>']['reduction'] = $('#COL_REDUCTION_<?= $item['id']; ?>').val()
                        items['<?= $item['id'] ?>']['tranche'] = tranches;
                        items['<?= $item['id'] ?>']['multiplicateur'] = tranches.length;
                        items['<?= $item['id'] ?>']['montant'] = _total;
                        items['<?= $item['id'] ?>']['montant_brut'] = _total;
                        items['<?= $item['id'] ?>']['montant_net'] = parseFloat(items['<?= $item['id'] ?>']['montant']) - parseFloat(items['<?= $item['id'] ?>']['reduction']);
                        $('#COL_RECAPITULATIF_<?= $item['id']; ?>').val(items['<?= $item['id'] ?>']['montant_net'])
                        init()
                        console.log(items['<?= $item['id'] ?>'])
                    })

                <?php } else { ?>
                    items['<?= $item['id'] ?>']['paiement_en_tranche'] = '<?= E::NON ?>';
                    //TYPE NUMBER
                    $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').on('change paste keyup mouseup', function() {
                        if ($('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val() < 0)
                            $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val(0)
                        console.log($('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val())
                        items['<?= $item['id'] ?>']['multiplicateur'] = $('#COL_TRANCHE_NUMERIC_<?= $item['id']; ?>').val()
                        items['<?= $item['id'] ?>']['reduction'] = $('#COL_REDUCTION_<?= $item['id']; ?>').val()
                        items['<?= $item['id'] ?>']['montant_brut'] = items['<?= $item['id'] ?>']['multiplicateur'] * items['<?= $item['id'] ?>']['montant']
                        items['<?= $item['id'] ?>']['montant_net'] = items['<?= $item['id'] ?>']['montant_brut'] - items['<?= $item['id'] ?>']['reduction']
                        $('#COL_RECAPITULATIF_<?= $item['id']; ?>').val(items['<?= $item['id'] ?>']['montant_net'])
                        init()
                        console.log(items['<?= $item['id'] ?>'])

                    })
                <?php } ?>
            <?php } ?>


            //TYPE NUMBER OF REMISE
            $('#COL_REDUCTION_<?= $item['id']; ?>').on('change paste keyup mouseup', function() {
                if ($('#COL_REDUCTION_<?= $item['id']; ?>').val() < 0)
                    $('#COL_REDUCTION_<?= $item['id']; ?>').val(0)
                items['<?= $item['id'] ?>']['reduction'] = parseFloat($('#COL_REDUCTION_<?= $item['id']; ?>').val())
                if (items['<?= $item['id'] ?>']['montant_brut'] === undefined) items['<?= $item['id'] ?>']['montant_brut'] = 0
                items['<?= $item['id'] ?>']['montant_net'] = parseFloat(items['<?= $item['id'] ?>']['montant_brut']) - parseFloat(items['<?= $item['id'] ?>']['reduction'])
                $('#COL_RECAPITULATIF_<?= $item['id']; ?>').val(items['<?= $item['id'] ?>']['montant_net'])
                init()
            })

        <?php } ?>

        // END---------------------------------------


        // BEGIN ACTIVITE---------------------------------------
        //COL2 ACTIVITE
        $('#COL_SELECT_LIBELLE_ACTIVITE').on('select2:close', function() {
            let select = $(this)
            select.trigger('change')
            // console.log('   ')
            var data = JSON.parse(JSON.stringify(select.select2('data')))

            var liste_activite = [];
            data.forEach(function(element) {
                console.log(element)
                liste_activite.push({
                    'id': element.id,
                    'value': element.text,
                    'montant': parseFloat(element.title)
                })
            })

            activites['liste'] = liste_activite;

            //Replicator
            var tranches = [];
            let total = 0
            activites['liste'].forEach(function(element) {
                total += element.montant
            })
            activites['montant'] = total
            activites['montant_brut'] = activites['montant'] * activites['multiplicateur']
            activites['montant_net'] = activites['montant_brut'] - activites['reduction']
            $('#COL_RECAPITULATIF_ACTIVITE').val(activites['montant_net'])
    
            // console.log( activites['montant_net'])
            // console.log( activites['montant'])
            // console.log( activites['multiplicateur'])
            // console.log( activites['reduction'])

            init()
        })

        //COL-3 TRANCH ESCOLARITE
        $('#COL_TRANCHE_SELECT_ACTIVITE').on('select2:close', function() {
            let select = $(this)
            select.trigger('change')
            // console.log('COL_TRANCHE_SELECT_ACTIVITE')
            var tranches = [];
            
            JSON.parse(JSON.stringify($('#COL_TRANCHE_SELECT_ACTIVITE').select2('data'))).forEach(function(element) {
                tranches.push({
                    'id': element.id,
                    'value': element.text
                })
            })
            activites['tranche'] = tranches;
            activites['multiplicateur'] = tranches.length;

            
            //Replicator
         

            activites['montant_brut'] = activites['montant'] * activites['multiplicateur']
            activites['montant_net'] = activites['montant_brut'] - activites['reduction']
            $('#COL_RECAPITULATIF_ACTIVITE').val(activites['montant_net'])
            
            // console.log( activites['montant_net'])
            // console.log( activites['montant'])
            // console.log( activites['multiplicateur'])
            // console.log( activites['reduction'])

            init()
            
        })

        //COL5 Activite


        $('#COL_REDUCTION_ACTIVITE').on('change paste keyup mouseup', function() {
            if ($('#COL_REDUCTION_ACTIVITE').val() < 0)
                $('#COL_REDUCTION_ACTIVITE').val(0)
            activites['reduction'] = $('#COL_REDUCTION_ACTIVITE').val()
            activites['montant_net'] = activites['montant_brut'] - activites['reduction']
            $('#COL_RECAPITULATIF_ACTIVITE').val(activites['montant_net'])
            
            // console.log( activites['montant_net'])
            // console.log( activites['montant'])
            // console.log( activites['multiplicateur'])
            // console.log( activites['reduction'])
            init()
        })
        // END---------------------------------------

        // BEGIN CANTINE---------------------------------------
        //COL5 Cantine
        $('#COL_REDUCTION_CANTINE').on('change paste keyup mouseup', function() {
            if ($('#COL_REDUCTION_CANTINE').val() < 0)
                $('#COL_REDUCTION_CANTINE').val(0)
            cantines['reduction'] = $('#COL_REDUCTION_CANTINE').val()
            cantines['montant_brut'] = cantines['montant'] * cantines['multiplicateur']
            cantines['montant_net'] = cantines['montant_brut'] - cantines['reduction']
            $('#COL_RECAPITULATIF_CANTINE').val(cantines['montant_net'])
            init()
        })

        //COL 3 Cantine
        $('#COL_TRANCHE_SELECT_CANTINE').on('select2:close', function() {
            let select = $(this)
            select.trigger('change')
            var data = JSON.parse(JSON.stringify(select.select2('data')))
            var tranches = []
            data.forEach(function(element) {
                console.log(element)
                tranches.push({
                    'id': element.id,
                    'value': element.text
                })
            })

            cantines['montant'] = prix_abonnement_cantine
            cantines['tranche'] = tranches;
            // console.log(cantines['mensualite'])
            cantines['multiplicateur'] = select.select2('data').length;
            // console.log(cantines['multiplicateur'])
            cantines['montant_brut'] = cantines['montant'] * cantines['multiplicateur']
            // console.log(cantines['montant_brut'])
            cantines['montant_net'] = cantines['montant_brut'] - cantines['reduction']
            // console.log(cantines['montant_net'])
            $('#COL_RECAPITULATIF_CANTINE').val(cantines['montant_net'])
            init()
        })
        // END---------------------------------------

        // BEGIN AUTRE---------------------------------------
        //COL2
        //COL 3 Autres
        $('#COL_MONTANT_AUTRES').on('change paste keyup mouseup', function() {
            let current = $(this)
            if (current.val() < 0)
                current.val(0)
            // console.log(current.val())
            autres['montant'] = current.val()
            autres['montant_brut'] = autres['montant']
            autres['montant_net'] = autres['montant_brut'] - autres['reduction'] 
            $('#COL_RECAPITULATIF_AUTRES').val(cantines['montant_net'])
            init()
        })

        //COL5 Autre
        $('#COL_REDUCTION_AUTRES').on('change paste keyup mouseup', function() {
            let current = $(this)
            if (current.val() < 0)
                current.val(0)
            autres['reduction'] = current.val()
            autres['montant_net'] = autres['montant_brut'] - autres['reduction'] 
            $('#COL_RECAPITULATIF_AUTRES').val(cantines['montant_net'])
            init()
        })
        //COL2 Autre
        $('#COL_LIBELLE_AUTRES').on('change paste keyup mouseup', function() {
            let current = $(this)
            // if (current.val() == '')
            //     autres['type_pension'] = ''
            autres['type_pension'] = current.val()
        })
        // END---------------------------------------

    })

    //INITIALISATION DU MULTIPLICATEUR

    //  MET A JOUR LE TYPE DE MULTIPLICATEUR QD LA VALEUR DE LA CLASSE CHANGE (HIDE/SHOW)
    //ToogleVisibleMultiplicator
    function trigger_classe(classe_id) {
        //Initilisation
        // console.log('pension_classe')
        // console.log(pension_classe)
        <?php foreach ($type_pensions as $type_pension) {   ?>
            <?php if ($type_pension['paiement_en_tranche'] == E::OUI) { ?>
                <?= "active_type_{$type_pension['id']}"; ?> = '#TYPE_SELECT_<?= $type_pension['id']; ?>'
                <?= "inactive_type_{$type_pension['id']}"; ?> = '#TYPE_NUMBER_<?= $type_pension['id']; ?>'
            <?php } else { ?>
                <?= "active_type_{$type_pension['id']}"; ?> = '#TYPE_NUMBER_<?= $type_pension['id']; ?>'
                <?= "inactive_type_{$type_pension['id']}"; ?> = '#TYPE_SELECT_<?= $type_pension['id']; ?>'
            <?php } ?>
            $(<?= "active_type_{$type_pension['id']}"; ?>).show()
            $(<?= "inactive_type_{$type_pension['id']}"; ?>).hide()
        <?php } ?>

        {

            if (classe_id === undefined) return
            console.log(classe_id)
            let type_pension = pension_classe['' + classe_id].type_pension
            // let type_pension_info = item.type_pension 
            let classe_info = type_pension.classe_info
            for (type_pension_id in type_pension) {
                console.log('type_pension_id')
                console.log(type_pension_id)
                let tranche_info = type_pension['' + type_pension_id].tranche_info
                let type_pension_info = type_pension['' + type_pension_id].type_pension_info
                console.log(type_pension['' + type_pension_id])
                items['' + type_pension_id]['reduction'] = 0
                items['' + type_pension_id]['paiement_en_tranche'] = type_pension_info.paiement_en_tranche

                //items['' + type_pension_id]['tranche_info'] = tranche_info
           
                if (type_pension_info.paiement_en_tranche == '<?= E::OUI ?>') {
                    $('#COL_TRANCHE_SELECT_' + type_pension_id).val(null)
                    $('#COL_TRANCHE_SELECT_' + type_pension_id).empty()

                    items['' + type_pension_id]['pension_classe_code'] = -1
                    items['' + type_pension_id]['montant'] = 0
                    // items['' + type_pension_id]['mensualite'] = tranche_info
                    items['' + type_pension_id]['multiplicateur'] = []
                    items['' + type_pension_id]['montant_net'] = 0
                    items['' + type_pension_id]['montant_brut'] = 0


                    $('#COL_TRANCHE_SELECT_' + type_pension_id).val(null)
                    $('#COL_TRANCHE_SELECT_' + type_pension_id).empty()
                    if (tranche_info.length > 0) {
                        tranche_info.forEach(function(subitem) {
                            // console.log(subitem)
                            var data = {
                                id: subitem.tranche_scolaire_code,
                                text: subitem.tranche_scolaire_libelle
                            }
                            var new_option = new Option(data.text, data.id, false, false);
                            $('#COL_TRANCHE_SELECT_' + type_pension_id).append(new_option)
                        })
                    }
                    $('#COL_TRANCHE_SELECT_' + type_pension_id).trigger('change');
                } else {
                    if (tranche_info.length > 0) {
                        items['' + type_pension_id]['pension_classe_code'] = tranche_info[0].id
                        items['' + type_pension_id]['montant'] = parseFloat(tranche_info[0].montant)
                        items['' + type_pension_id]['montant_brut'] = 0
                        console.log('____________|||||||||||||||______________')
                        console.log(type_pension_id)
                        $('#COL_TRANCHE_NUMERIC_' + type_pension_id).prop("readonly", false);
                    } else {
                        items['' + type_pension_id]['pension_classe_code'] = -1
                        items['' + type_pension_id]['montant'] = 0
                        $('#COL_TRANCHE_NUMERIC_' + type_pension_id).prop("readonly", true);
                    }
                    // items['' + type_pension_id]['mensualite'] = []
                    items['' + type_pension_id]['multiplicateur'] = 0
                    items['' + type_pension_id]['montant_brut'] = items['' + type_pension_id]['montant'] * items['' + type_pension_id]['multiplicateur']
                    items['' + type_pension_id]['montant_net'] = items['' + type_pension_id]['montant_brut'] - items['' + type_pension_id]['reduction']
                    $('#COL_TRANCHE_NUMERIC_' + type_pension_id).val(items['' + type_pension_id]['multiplicateur'])
                    
                }

                if (type_pension_id == '<?= TypePension::INSCRIPTION_CODE ?>') {
                        
                    $('#COL_TRANCHE_NUMERIC_' + type_pension_id).prop("readonly", true);
                    if ('<?= !(isset($data_inscriptpion)) ?>')
                        $('#COL_TRANCHE_NUMERIC_' + type_pension_id).prop("readonly", false);
                    
                    // items['' + type_pension_id]['mensualite'] = []
                    items['' + type_pension_id]['pension_classe_code'] = tranche_info[0].id
                    items['' + type_pension_id]['multiplicateur'] = 1
                    items['' + type_pension_id]['montant_brut'] = items['' + type_pension_id]['montant'] * items['' + type_pension_id]['multiplicateur']
                    items['' + type_pension_id]['montant_net'] = items['' + type_pension_id]['montant_brut'] - items['' + type_pension_id]['reduction']
                    $('#COL_TRANCHE_NUMERIC_' + type_pension_id).val(items['' + type_pension_id]['multiplicateur'])
                }

                $('#COL_REDUCTION_' + type_pension_id).val(items['' + type_pension_id]['reduction'])
                $('#COL_RECAPITULATIF_' + type_pension_id).val(items['' + type_pension_id]['montant_net'])

                console.log(items['' + type_pension_id]['type_pension'] )
                console.log(items['' + type_pension_id]['pension_classe_code'] )
                console.log(items['' + type_pension_id]['tranche_info'] )
            }
        }
    }

</script>