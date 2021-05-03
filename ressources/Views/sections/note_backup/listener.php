<script>

$(document).ready(function () {
  
    $(document).on('click', '.duallistbox-refresh', function(e){
        duallistboxDynamic.bootstrapDualListbox('refresh')
        let salle_classe_code = $(this).data('id')
        apiRefreshCardSalleClasseAffectation(salle_classe_code)
        alert('Actualisaiton effectuée avec succes', 'Youpi', 'success')
    })

    $(document).on('click', '.duallistbox-save', function(e){
        console.log('save')
        let salle_classe_code = $(this).data('id')

        let name = salle_classe_code
        let unselected_options = $('select[name="' + name + '"] :not(option:selected)')
        let selected_options = $('select[name="' + name + '"] option:selected')

        let values_selected = $.map( selected_options, function(option) { return option.value })
        let values_unselected = $.map( unselected_options, function(option) { return option.value })

        apiSaveAffectationSalleClasseAffectation(salle_classe_code, values_selected, values_unselected)

        alert('Sauvegarde effectuée avec succes', 'Youpi', 'success')
    })

    $(document).on('click', '.duallistbox-cancel', function(e){
        console.log('cancel')
        duallistboxDynamic.bootstrapDualListbox('refresh')
        let salle_classe_code = $(this).data('id')
        apiRefreshCardSalleClasseAffectation(salle_classe_code)
        alert('Actualisaiton effectuée avec succes', 'Youpi', 'success') 
    })
})

</script>

<script>
        var noAction = true
        //MISE A JOUR CHAQUE <?= REFRESH_TIME_DATATABLE ?> SECONDES
        
        //TRIGGER TO DETERMINE ACTIVITY OF USER TO REFREH OR NOT THE PAGE
        $(document).on('change', 'select', function(e){
                noAction = false
        })

        setInterval( 
            function () {
                if(noAction) {
                    apiCall()
                    noAction = true
                }

            }, <?= REFRESH_TIME_DATATABLE ?>
        )

</script>
