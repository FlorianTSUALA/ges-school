<?php

use Core\Routing\URL;
use App\Helpers\Helpers;
use App\Model\Eleve;
use App\Model\Facture;

include dirname(dirname(dirname(__DIR__)))."/_common_lib/_select2_script.php";

?>
<!--
    ******  VARIABLES *****
     $base_route
     $fillables
     $msg_delete
-->



<script> 
  let msg  = 'Bienvenue à la section qui liste de tous les élèves de l\'établissement de toutes les années confondues'
  block_notification(msg)
  
  var filter_by = 'ALL'
  var date = '<?= Helpers::today() ?>'
  var table
 
  function init_data_table() {
        // $('#table-eleve').append('<caption style="caption-side: top-right">Table caption</caption>');

          table = $('#table-recap_versement_journalier').DataTable({
              //"serverSide": true,
              //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
              ajax:{
                  url: '<?= URL::link('facture_api_info') ?>',
                  data: function(data){
                      data.date =  date,
                      data.filter_by =  filter_by
                  } ,
                  type: 'POST'
              },
              "columns": [<?= Facture::getColumnsomme() ?>],
              order: [[ 1, 'asc' ]],
              scrollY:        "700px",
              scrollX:        true,
              scrollCollapse: true,
              // paging:         false,

            
              fixedColumns: true,
              "columnDefs": [
                {
                  "targets": 0,
                  width: '3%',
                  "searchable": false,
                  // "orderable": false,
                  "class": "index",
                   
                },      
            
                {
                  "targets": -1,
                  width: '7%', 
                  "data": null,
                  "render": function(data, type, full, meta){ 
                       console.log(data);

                      //       <button data-id="'. $model[FrequentlyReapeat::CODE] .'" type="button" class=" btn_read_data btn btn-sm btn-blue"><i class="ft-eye"></i></button>
                      //      <button data-id="'. $model[FrequentlyReapeat::CODE] .'" type="button" class=" btn_update_data btn btn-sm btn-green"><i class="ft-edit-2"></i></button>
                      //      <button data-id="'. $model[FrequentlyReapeat::CODE] .'" type="button" class=" btn_delete_data btn btn-sm btn-danger"><i class="ft-trash-2"></i></button>                     
                           

                        return  ' '+
                                ' <div class="btn-group" role="group" aria-label="Basic example"> '+
                                '      <button type="button" data-action="action-voir" class="action btn btn-sm btn-icon btn-blue mr-0" title="voir"><i class="ft-eye"></i></button> '+
                                '      <button type="button" data-action="action-modifier" class="action btn btn-sm btn-icon btn-green mr-0" title="modifier"><i class="ft-edit-2"></i></button> '+
                                '      <button type="button" data-action="action-supprimer" class="action btn btn-sm btn-icon btn-danger mr-0" title="supprimer"><i class="ft-trash"></i></button> '+
                                '  </div>'

                    }
                }
            ],
            "createdRow": function(row, data, index) {
                  // let date = new Date(data.date).toLocaleDateString(window.navigator.language, {year: 'numeric',month: 'long',day: 'numeric',});
              },
              "fnDrawCallback": function( oSettings ) {
                  // $('#table-emprunt').append('<caption style="caption-side: top-right">Table caption</caption>');
              },
            <?= Helpers::dataTableCommunOptions() ?>
            dom:
              "<'d-flex justify-content-between'<'p-2'l><'p-2'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            renderer: 'bootstrap',
              // "destroy" : true,
              // dom: 'Blfrtip',
              // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
              stateSave: true,
              
          })

          table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                  cell.innerHTML = i+1;
              } );
          } ).draw();

          $('#table-versement1 tbody').on( 'click', 'button.action', function () {
              // var id = $(this).data('id');
              var action = $(this).data('action');
              //alert('hello')
              console.log(action)
              var data = table.row( $(this).parents('tr') ).data()
              console.log(data)
              let id = data.id
              console.log(data)
              console.log(id)
              // return

              // let num = data.num
              // let code_enregistrement = data.code_enregistrement
              // let titre = data.titre
              // let eleve = data.eleve
              // let date_emprunt = data.date_emprunt
              // let date_expiration = data.date_expiration
              // let classe = data.classe
              // let etat_document = data.etat_document

      

              // alert( id, num, code_enregistrement, titre, eleve, date_emprunt, date_expiration, classe, etat_document )
          } )

  }

  //Reload table data every 30 seconds (paging retained):
  setInterval( function () {
      table.ajax.reload( null, false ); // user paging is not reset on reload
  }, <?= REFRESH_TIME_DATATABLE ?> );

  (function(window, document, $){
    init_data_table()
  })(window, document, jQuery)

</script>

