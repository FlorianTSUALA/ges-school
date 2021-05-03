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

    var db = {

        loadData: function(filter) { 
            let data = filter
            data.classe = (!filter.classe || (filter.classe === "Toutes les classes"))? null : filter.classe
            return $.ajax({
                        type: "POST",
                        url: "<?= URL::link('affectation_salle_enseignant_all');?>",
                        data: data
                    });
            // return $.grep(db.personnels_salle_classes, function(item) {
            //     return ( 
            //         (!filter.classe || item.classe === filter.classe  || filter.classe === "Toutes les classes"))
            //         // && (!filter.salle_classe || item.salle_classe === filter.salle_classe)
            //         // && (!filter.personnel || item.personnel === filter.personnel)
            // })
        },

        insertItem: function(insertingAffectation) {
            this.personnels_salle_classes.push(insertingAffectation);
        },

        updateItem: function(updatingAffectation) { 
            var result = $.Deferred();
                
            let data = {}
            data['salle_classe_id'] = lastCurItem.salle_classe
            data['personnel_id'] = lastCurItem.personnel
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
                        url: '<?= URL::link('affectation_salle_enseignant_update');?>',
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
            var AffectationIndex = $.inArray(deletingAffectation, this.personnels_salle_classes);
            this.personnels_salle_classes.splice(AffectationIndex, 1);
        }

    };

    window.db = db;

    db.personnels = <?= $personnels ?>;
    
    db.personnels.unshift(    {
        id: null,
        value: 'Non affecté'
    })

    // console.log(db.personnels)
    
    db.classes = <?= $classes ?>;
        
    db.classes.unshift(    {
        id: null,
        value: 'Toutes les classes'
    })

    db.salle_classes = <?= $salle_classes ?>;

    db.personnels_salle_classes = <?= $affectation_personnel_salle_classes ?>;

    
    $("#table_affectation_personnel_salle_classe").jsGrid({
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
            { name: "salle_classe", title: "Salle de classe", type: "select2", items: db.salle_classes, valueField: "id", textField: "value" , editing: false, filtering: false,},
            { name: "personnel", title: "personnel", type: "select2", items: db.personnels, valueField: "id", textField: "value", filtering: false, filtercss: "width: 100%;", },
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
        
        rowClick: function(args) {
            grid = this;

            if(( $(args.event.target.parentNode).find('input.jsgrid-edit-button').length == 1)) {
                console.log('yes')
                df = $.Deferred();
                
                $.ajax({
                    type: "GET",
                    url: '<?= URL::link('api_personnel_list');?>'
                }).done(function(data) {
                    
                    db.personnels = [ {
                        id: null,
                        value: 'Non affecté'
                    }]

                    db.personnels.push(...data)
                    
                    $("#jsGrid").jsGrid("fieldOption", "personnel", 'items', db.personnels)
                    
                    df.resolve()
                })
                
                df.then(function (){
                    grid.editItem(args.item);                    
                })
                return df.promise() 
            }
        }

    })

 

    //MISE A JOUR CHAQUE 10 SECONDES
    setInterval(function(){
        $("#table_affectation_personnel_salle_classe").jsGrid("loadData")
    }, 10000);


}())

</script>