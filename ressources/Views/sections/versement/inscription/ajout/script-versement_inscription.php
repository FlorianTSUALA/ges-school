<?php

use App\Helpers\S;

?>

<script>
    var tranches = []
    var isFirstLoad = true
    var fromInscription = <?= ($this->session->has(S::DATA_TRANSPORT))? 'true' : 'false' ;?>

    var type_pension = $('#type_pension')
    var eleve_nom_complet = $('#eleve_nom_complet')
    var classe = $('#classe')
    var statut_apprenant = $('#statut_apprenant')

    var reduction = $('.reduction')
    // var reste = $('#reste')
    var montant = $('#montant')

    var section_versement = $('#section_versement')
    var section_recaputilatif = $('#section_recaputilatif')

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

    function init(){

        if(isFirstLoad){
            trigger($(classe).select2().find(':selected').data('id'))
            isFirstLoad = false;
        }

        let _montant_total = 0;
        let i = 0;



        // //Reste
            // _reduction = parseFloat($(reduction).val())
            // _reste = parseFloat($(reste).val())
            // _montant_total -= _reduction
            _montant_total -= _reste
            let reduction_familiale = (isNaN($('#RF-reduction').val()))? 0 : $('#RF-reduction').val()
            _montant_total = _montant_total - reduction_familiale
            $(montant).val(_montant_total)
        // //Reste

    }

    //INITIALISATION DU MULTIPLICATEUR

    //  MET A JOUR LE TYPE DE MULTIPLICATEUR QD LA VALEUR DE LA CLASSE CHANGE (HIDE/SHOW)
    //ToogleVisibleMultiplicator
    function trigger(classe_id){
 
}
    $(document).ready(function(){

        $(btn_home).hide()
        $(btn_print).hide()

        $(eleve_nom_complet).on("select2:select select2:unselecting", function () {
            $(eleve_nom_complet).select2('data')
            init()
        })

        $(classe).on("select2:select select2:unselecting", function () {
            trigger($(classe).select2().find(":selected").data("id"))
            init()
        })


        $(reduction).on("change paste keyup mouseup", function () {
            if($(reduction).val() < 0)
                $(reduction).val(0)
            init()
        })

        // $(reste).on("change paste keyup mouseup", function () {
        //     if($(reste).val() < 0)
        //         $(reste).val(0)
        //     init()
        // })

        $(btn_preview).click(function() {
            $(section_versement).hide()
            $(section_recaputilatif).show()
        })

        $(btn_back).click(function() {
            $(section_recaputilatif).hide()
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