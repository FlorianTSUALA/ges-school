<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>
<!-- 
<div id="content">
  <button type="button" id="btnBatchEdit">
    Edit batch data
  </button>
  <button type="button" id="btnBatchSave">
    Save batch data
  </button>
</div>
<div id="jsGrid"></div>

    // NOM,PRENOM,DATE DE NAISSANCE,LIEU DE NAISSANCE ,NATIONALITE,SEXE,CLASSE ANNEE ENCOURS,CLASSE ANTERIEUR,INSCRIPTION

 -->

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
                        url: "<?= URL::link('api_loader_eleve_display_data');?>",
                        data: data
                    });
            // return $.grep(db.collection_eleve, function(item) {
            //     return ( 
            //         (!filter.classe || item.classe === filter.classe  || filter.classe === "Toutes les classes"))
            //         // && (!filter.salle_classe || item.salle_classe === filter.salle_classe)
            //         // && (!filter.personnel || item.personnel === filter.personnel)
            // })
        },

        insertItem: function(item) {
            this.collection_eleve.push(item);
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
            var AffectationIndex = $.inArray(deletingAffectation, this.collection_eleve);
            this.collection_eleve.splice(AffectationIndex, 1);
        }

    };

    window.db = db;

    


    db.pays = <?php print_r($pays??[])  ?>;
    db.sexes = <?php print_r($sexes??[])  ?>;
    db.classes = <?php print_r($classes??[])  ?>;

    db.pays.unshift(    {
        id: null,
        value: 'pays ???'
    })

    db.sexes.unshift(    {
        id: null,
        value: 'sexe ???'
    })

    db.classes.unshift(    {
        id: null,
        value: 'classe ???'
    })


    
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
        noDataContent: "Oh la liste vide !!! Chargez un fichier de données.",
        fields: [
            // NOM,PRENOM,DATE DE NAISSANCE,LIEU DE NAISSANCE ,NATIONALITE,SEXE,CLASSE ANNEE ENCOURS,CLASSE ANTERIEUR,INSCRIPTION

            { name: "nom", title: "Nom", type: "text", editing: false, filtering: true,},
            { name: "prenom", title: "Prenom", type: "text", editing: false, filtering: true,},
            { name: "date_naissance", title: "Date Naissance", type: "text", editing: false, filtering: true,},
            { name: "lieu_naissance", title: "Lieu Naissance", type: "text", editing: false, filtering: true,},
            { name: "nationalite", title: "nationalite", type: "select2", items: db.pays, valueField: "id", textField: "value" , editing: false, filtering: true,},
            { name: "sexe", title: "sexe", type: "select2", items: db.sexes, valueField: "id", textField: "value", filtering: false, filtercss: "width: 100%;", },
            { name: "classe_annee_en_cours", title: "classe", type: "select2", items: db.classes, valueField: "id", textField: "value", filtering: false, filtercss: "width: 100%;", },
            { name: "classe_anterieur", title: "classe anterieur", type: "text", filtering: false, filtercss: "width: 100%;", },
            { name: "inscription", title: "inscription", type: "text", filtering: false, filtercss: "width: 100%;", },
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


        onInit: function(args) {
        }, 
        
        /*
        
            onItemUpdating: function(args) {
                lastPrevItem = args.previousItem;
                lastCurItem = args.item;
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
            },
            
        */

        _editRowBatch: function($row) {
            if (!this.editing)
            return;

            var item = $row.data(JSGRID_ROW_DATA_KEY);

            var args = this._callEventHandler(this.onItemEditing, {
            row: $row,
            item: item,
            itemIndex: this._itemIndex(item)
            });

            if (args.cancel)
            return;

            var $editRow = this._createEditRow(item);

            $row.hide();
            $editRow.insertBefore($row);
            $row.data(JSGRID_EDIT_ROW_DATA_KEY, $editRow);
        },

        editItemBatch: function(item) {
            var $row = this.rowByItem(item);
            if ($row.length)
            this._editRowBatch($row);
        },

        setEditingRow: function($row) {
            this._editingRow = $row;
            this.editing = true;
        },

        getEditingRow: function() {
            return this._editingRow;
        }

    })

 

    //MISE A JOUR CHAQUE 10 SECONDES
    setInterval(function(){
        $("#table_affectation_personnel_salle_classe").jsGrid("loadData")
    }, 10000);


    $('.input_file_upload').on('click', function(){
        document.getElementById($(this).data('target')).click()
    })

    function load_jsgrid(input, selector){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(selector)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

        /*
            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);

            $.ajax({
                url : 'upload.php',
                type : 'POST',
                data : formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    console.log(data);
                    alert(data);
                }
            });

        */

        }

    }



}())

</script>