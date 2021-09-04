<?php

use App\Helpers\S;

?>

<script>
    var tranches = []
    var isFirstLoad = true

    var type_pension = $('#type_pension')
    var eleve_nom_complet = $('#eleve_nom_complet')
    var classe = $('#classe')
    var tranche = $('#COL_TRANCHE_SCOLARITE')
    var statut_apprenant = $('#statut_apprenant')

    var reduction = $('#COL_REDUCTION_SCOLARITE')
    var montant = $('#montant')

    var section_versement = $('#section_versement')
    var section_recapitulatif = $('#section_recapitulatif')

    var btn_preview = $('#btn_preview')
    var btn_save = $('#btn_save')
    var btn_home = $('#btn_home')
    var btn_back = $('#btn_back')
    var btn_print = $('#btn_print')
    var loading = $('#loading')

    var eleve_id
    var eleve_matricule
    var classe_id
    var type_pension_id
    var _montant = 0
    var _est_mensuel = 0
    var _mensualite = 0
    // var _reduction = 0
    var _reste = 0

    var prix_scolarite_tranche_classe = <?= json_encode($prix_scolarite_tranche_classe); ?>;
    var pension_classes = <?= json_encode($pension_classe); ?>;
    let data = 'Bienvenue à la section dédiée aux versements scolaires'


    var autres = {}
    var scolarites = {}
    
    autres['libelle'] = ""
    autres['reduction'] = 0
    autres['montant'] = 0
    autres['montant_net'] = 0
    
    scolarites['libelle'] = "SCOLARITE"
    scolarites['reduction'] = 0
    scolarites['montant'] = 0
    scolarites['montant_net'] = 0


    function init(){

        if(isFirstLoad){
            trigger_classe($(classe).select2().find(':selected').data('id'))
            isFirstLoad = false;
        }

        let reduction_familiale = (isNaN($('#RF-reduction').val()))? 0 : $('#RF-reduction').val()
        let msg = autres['montant_net'] + scolarites['montant_net'] - reduction_familiale
        $(montant).val(msg)

        console.log(msg)
        console.log( autres['montant_net'])
        console.log(scolarites['montant_net'])

    }

    $(document).ready(function(){
        flash_msg(data)
        
        $(btn_home).hide()
        $(btn_print).hide()

        $(eleve_nom_complet).on("select2:select select2:unselecting", function () {
            $(eleve_nom_complet).select2('data')
        })

        $(classe).on("select2:select select2:unselecting", function () {
            trigger_classe($(classe).select2().find(":selected").data("id"))
        })

        $(tranche).on("select2:select select2:unselecting", function () {
            trigger_tranche(( ($(tranche).select2('data')) ), $(classe).select2().find(":selected").data("id"))
        })

        trigger_classe($(classe).select2().find(":selected").data("id"))


        $(btn_preview).click(function() {
            $(section_versement).hide()
            $(section_recapitulatif).show()
        })

        $(btn_back).click(function() {
            $(section_recapitulatif).hide()
            $(section_versement).show()
        })

        $(btn_save).click(function() {
            sauvegarderVersement()
        })
        
        $(btn_print).click(function() {
            imprimerRecuVersement()
        })
        
        init()
    })

</script>