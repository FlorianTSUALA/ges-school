<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>

<script>

<?php Helpers::jsResponsibleSelect2JsGrid() ?>

// http://js-grid.com/docs/#controller

$(document).ready(function() {
    var lastPrevItem
    var lastCurItem
    var grid
    var table = $("#table_pension_classe")

    var db = {

        loadData: function(filter) { 
            let data = filter
            data.classe = (!filter.classe || (filter.classe === "Toutes les classes"))? null : filter.classe
            data.type_pension = (!filter.type_pension || (filter.type_pension === "Toutes les types pensions"))? null : filter.type_pension
            return $.ajax({
                        type: "POST",
                        url: "<?= URL::link('pension_classe_all');?>",
                        data: data
                    });
        },

        insertItem: function(insertingAffectation) {
            this.prix_pensions_classes.push(insertingAffectation);
        },

        updateItem: function(updatingAffectation) { 
            var result = $.Deferred();
                
            let data = {}
            data['classe_id'] = lastCurItem.classe
            data['tranche_scolaire_id'] = lastCurItem.tranche_scolaire
            data['type_pension_id'] = lastCurItem.type_pension
            data['montant'] = lastCurItem.montant
            if(lastCurItem.personnel == "Non affecté")
                data['personnel_id'] = null

            $.blockUI({
                message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Enregistrement en cours ...</div>',
                fadeIn: 1000,
                timeout: 3000, //unblock after 2 seconds
                overlayCSS: {
                    backgroundColor: '#FFF',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: '10px 15px',
                    color: '#fff',
                    width: 'auto',
                    left: '45%',
                    backgroundColor: '#333'
                },
                onBlock: function() {
                    $.ajax({
                        url: '<?= URL::link('pension_classe_update');?>',
                        type: 'post',
                        data: data,
                        dataType: 'json',
                    
                        success:function(data){
                            
                            if(data.report){
                                flash_msg(data.data, 3)
                                result.resolve(lastCurItem)
                            }else{
                                // d = true
                                result.resolve(lastPrevItem)

                                // args.cancel = true;
                                // _robust\_Robust\Robust\Robust\html\ltr\vertical-multi-level-menu-template\ex-component-sweet-alerts.html
                                alert(data.data, 'Oupss.... ', 'error')
                            }
                            

                            // console.log(data)

                        },
                        error: function (textStatus, errorThrown) {
                            Success = false;
                            result.resolve(lastPrevItem)

                            console.log(textStatus, errorThrown);
                        }
                    });               
                }
            });

            return result.promise();
        },
        

        deleteItem: function(deletingAffectation) {
            var AffectationIndex = $.inArray(deletingAffectation, this.prix_pensions_classes);
            this.prix_pensions_classes.splice(AffectationIndex, 1);
        }

    };

    window.db = db;

    db.classes = <?= $classes ?>;
    db.classes.unshift(    {
        id: null,
        value: 'Toutes les classes'
    })

    db.types_pensions = <?= $types_pensions ?>;
    db.types_pensions.unshift(    {
        id: null,
        value: 'Toutes les types pensions'
    })

    db.tranches_scolaires = <?= $tranches_scolaires ?>;

    db.prix_pensions_classes = <?= $prix_pensions_classes ?>;


    
    table.jsGrid({
        width: "100%",
        filtering: true,
        editing: true,
        inserting: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 15,
        pageButtonCount: 5,
        controller: db,
        noDataContent: "Aucune correspondance trouvée",
        fields: [
            { name: "classe", title: "Classe", type: "select2", items: db.classes, valueField: "id", textField: "value" , editing: false, filtering: true,},
            { name: "type_pension", title: "Type pension", type: "select2", items: db.types_pensions, valueField: "id", textField: "value" , editing: false, filtering: true,},
            { name: "tranche_scolaire", title: "Tranche scolaire", type: "select2", items: db.tranches_scolaires, valueField: "id", textField: "value", editing: false, filtering: false, filtercss: "width: 100%;", },
            { name: "montant", title: "Montant", type: "number", filtering: false, filtercss: "width: 100%;" },
            { 
                type: "control", 
                deleteButton: false,
                searchModeButtonTooltip: "Switch to searching", // tooltip of switching filtering/inserting button in inserting mode
                insertModeButtonTooltip: "Switch to inserting", // tooltip of switching filtering/inserting button in filtering mode
                editButtonTooltip: "Modifier",                      // tooltip of edit item button
                deleteButtonTooltip: "Supprimer",                  // tooltip of delete item button
                searchButtonTooltip: "Rechercher",                  // tooltip of search button
                clearFilterButtonTooltip: "réinitialiser le filtre de recherche",       // tooltip of clear filter button
                insertButtonTooltip: "Insertion",                  // tooltip of insert button
                updateButtonTooltip: "Mise à jour",                  // tooltip of update item button
                cancelEditButtonTooltip: "Annuler la modification",         // tooltip of cancel editing button
            }
        ],
        onItemUpdating: function(args) {
            lastPrevItem = args.previousItem;
            lastCurItem = args.item;
        },
        onInit: function(args) {
        }, 
    })

 

    //MISE A JOUR CHAQUE 10 SECONDES
    setInterval(function(){
        table.jsGrid("loadData")
    },  <?= REFRESH_TIME_DATATABLE ?>);


}())

</script>