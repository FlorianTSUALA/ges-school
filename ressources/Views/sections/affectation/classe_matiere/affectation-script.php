<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>


<script>

<?php Helpers::jsResponsibleSelect2JsGrid() ?>

// http://js-grid.com/docs/#controller
var table = $("#table_affectation_personnel_salle_classe")

$(document).ready(function() {
    var lastPrevItem
    var lastCurItem
    var grid
    var classe_id = <?= json_decode($classes)[0]->id ?> 

    var db = {

        loadData: function(filter) { 
            let data = filter
            console.log("data.classe")
            console.log(data.classe)
            data.classe = (!filter.classe || (filter.classe === "Toutes les classes"))? null : filter.classe
            data.classe = (data.classe === null  || data.classe === undefined) ? classe_id : data.classe
            
            console.log("classe_id")
            console.log(classe_id)
            return $.ajax({
                        type: "POST",
                        url: "<?= URL::link('affectation_classe_matiere_all');?>",
                        data: data
                    })
        },

        insertItem: function(insertingAffectation) {
            // console.log('## # # INSERTION # # ##')
            // console.log(insertingAffectation)
            var result = $.Deferred()
            let data = {}
            data['classe_id'] = insertingAffectation.classe
            data['matiere_id'] = insertingAffectation.matiere
            data['coefficient'] = insertingAffectation.coefficient

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
                        url: '<?= URL::link('affectation_classe_matiere_save');?>',
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
                        },
                        complete: function(data) {
                            table.jsGrid("loadData", { classe: classe_id})
                        }
                    });               
                }
            })

            return result.promise()
        },

        updateItem: function(updatingAffectation) { 
            // console.log('## # # MODIFICATION # # ##')
            // console.log(updatingAffectation)
            var result = $.Deferred()
                
            let data = {}
            data['classe_id'] = updatingAffectation.classe
            data['matiere_id'] = updatingAffectation.matiere
            data['coefficient'] = updatingAffectation.coefficient

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
                        url: '<?= URL::link('affectation_classe_matiere_update');?>',
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
                        },
                        complete: function(data) {
                            table.jsGrid("loadData", { classe: classe_id})
                        }
                    });               
                }
            })

            return result.promise()
        },
        
        deleteItem: function(deletingAffectation) {
            // var AffectationIndex = $.inArray(deletingAffectation, this.affectation_classe_matiere)
            // this.affectation_classe_matiere.splice(AffectationIndex, 1)

             // console.log('## # # MODIFICATION # # ##')
            // console.log(updatingAffectation)
            var result = $.Deferred()
                
            let data = {}
            data['classe_id'] = deletingAffectation.classe
            data['matiere_id'] = deletingAffectation.matiere

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
                        url: '<?= URL::link('affectation_classe_matiere_delete');?>',
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
                        },
                        complete: function(data) {
                            table.jsGrid("loadData", { classe: classe_id})
                        }
                    });               
                }
            })

            return result.promise()
        }

    }

    window.db = db


    // console.log(db.matieres)
    
    db.classes = <?= $classes ?>
       
    db.classes.unshift(    {
        id: null,
        value: 'Toutes les classes'
    })

    db.matieres = <?= $matieres ?>
        
    db.matieres.unshift(    {
        id: null,
        value: 'Toutes les matieres'
    })

    db.affectation_classe_matiere = <?= $affectation_classe_matiere ?>

    
    table.jsGrid({
        width: "100%",
        filtering: false,
        editing: true,
        inserting: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 15,
        pageButtonCount: 5,
        controller: db,
        noDataContent: "Aucune correspondance trouvée",
        invalidMessage: "   ",
        confirmDeleting: true,
        deleteConfirm: "Voulez vous supprimer cette enregistrement ?",
        fields: [
            { name: "classe", title: "Classe", type: "select2", items: db.classes, valueField: "id", textField: "value" , editing: false, filtering: false,
                validate: [
                    { 
                        validator: function(value, item) {
                                return  value != "Toutes les classes"
                        },
                        message: "Selectionner une classe" 
                    },
                ] 
            },
            { name: "matiere", title: "Matiere", type: "select2", items: db.matieres, valueField: "id", textField: "value" , editing: false, filtering: true,
                validate: [
                    { 
                        validator: function(value, item) {
                                return  value != "Toutes les matieres"
                        },
                        message: "Selectionner une matiere" 
                    },
              ] 
            },
            { name: "coefficient", title: "Coef", type: "number", editing: true, filtering: false, filtercss: "width: 100%;", 
              validate: [
                    // "required",
                    { 
                        validator: "range", 
                        message: function(value, item) {
                            //TODO switch et controllé value non définie, valeur inf 1 et sup 100
                            switch(value){
                                case undefined:
                                    return "La valeur du coefficient doit supérieure à 1 ♠ La valeur entrée est \"" + ((value == undefined)?'vide':value)  + "\".";
                            case 'Toutes les matieres':
                                return "La valeur du  La valeur entrée est \"" + ((value == undefined)?'vide':value)  + "\".";
                            case 'Toutes les classes':
                                return "La valeur du  La valeur entrée est \"" + ((value == undefined)?'vide':value)  + "\".";
                            default:
                                return 'ok'
                            }
                        },
                        param: [1, 100] 
                    },
                    // function(value, item) {
                    //     return item.coefficient > 0;
                    // },
                ],
                insertTemplate: function() { 
                    var $result = jsGrid.fields.text.prototype.insertTemplate.call(this); // original input

                    $result.val('1');

                    return $result;
                }
            },
            { 
                type: "control", 
                deleteButton: true,
                searchModeButtonTooltip: "Basculer en mode Rechercher", // tooltip of switching filtering/inserting button in inserting mode
                insertModeButtonTooltip: "Basculer en mode Insertion", // tooltip of switching filtering/inserting button in filtering mode
                editButtonTooltip: "Modifier",                      // tooltip of edit item button
                deleteButtonTooltip: "Supprimer",                  // tooltip of delete item button
                                // tooltip of search button
                searchButtonTooltip: "Rechercher",                  // tooltip of search button
                clearFilterButtonTooltip: "Réinitialiser le Filtre de Recherche",       // tooltip of clear filter button
                insertButtonTooltip: "Cliquer pour enregistrer",                  // tooltip of insert button
                updateButtonTooltip: "Cliquer pour mettre à jour",                  // tooltip of update item button
                cancelEditButtonTooltip: "Annuler la Modification",         // tooltip of cancel editing button
            }
        ],
        onItemInserting: function(args) {
            lastPrevItem = args.previousItem;
            lastCurItem = args.item;
        },
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
                    url: '<?= URL::link('api_matiere_list');?>'
                }).done(function(data) {
                    
                    db.matieres = []
                    db.matieres.push(...data)
                    
                    $("#jsGrid").jsGrid("fieldOption", "matiere", 'items', db.matieres)
                    
                    df.resolve()
                })
                
                df.then(function (){
                    grid.editItem(args.item);                    
                })
                return df.promise() 
            }
        }

    })

    console.log("Start")

    //MISE A JOUR CHAQUE 10 SECONDES
    setInterval(function(){
        table.jsGrid("loadData", { classe: classe_id})
    }, <?= REFRESH_TIME_DATATABLE ?>);


}())



//   //Reload table data every 30 seconds (paging retained):
//   setInterval( function () {
//       table.ajax.reload( null, false ); // user paging is not reset on reload
//   }, <?= REFRESH_TIME_DATATABLE ?> );

//   (function(window, document, $){
//     init_data_table()
//   })(window, document, jQuery)


</script>


<script>
$('#menu .list-group a.list-group-item').first().addClass('active')
$('#menu .list-group a.list-group-item').click(function(e) {
  $('#menu .list-group a.list-group-item.active').removeClass('active');
  var $current = $(this)
  $current.addClass('active');
  e.preventDefault();
  if(this.id.includes('ID_')){
    classe_id = this.id.replace('ID_', '')
  }
  table.jsGrid("loadData", { classe: classe_id})
  console.log(classe_id)
});

</script>