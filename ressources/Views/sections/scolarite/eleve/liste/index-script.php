<?php

use Core\Routing\URL;
use App\Helpers\Helpers;
use App\Model\Eleve;

include dirname(dirname(dirname(__DIR__)))."/_common_lib/_select2_script.php";

?>
<!--
    ******  VARIABLES *****
     $base_route
     $fillables
     $msg_delete
-->



<script> 
  var code = ''
  var filter_by = 'ALL'

  let msg  = 'Bienvenue à la section qui liste de tous les élèves de l\'établissement de toutes les années confondues'
  block_notification(msg)

    function redirectTo(id = false){
        id = (id == false) ? $('#recap-id').text(): id;
        location.href = '<?= URL::link('eleve_modifier') ?>'+id
    }


    
  function delete_eleve(id){
      $.ajax({
          url: '<?= URL::link('eleve_api_delete_eleve');?>'+id,
          type: 'post',
          cache: true,
          dataType: 'json',
          beforeSend:function(){
          },
          success:function(data){
              
              table.ajax.reload( null, false ); // user paging is not reset on reload
              swal("Bingo !!!", "Suppression réalisée avec sucess !!!", 'success')

          },
          error: function (textStatus, errorThrown) {
              Success = false;
              swal("Erreur", "Erreur de communication avec le serveur ", "error");
              console.log(textStatus, errorThrown);
          }
      });    
  }
  
  function init_data_table() {
        // $('#table-eleve').append('<caption style="caption-side: top-right">Table caption</caption>');

          table = $('#table-eleve').DataTable({
              //"serverSide": true,
              //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
              ajax:{
                  url: '<?= URL::link(' api_eleve_all') ?>',
                  data: function(data){
                      data.code =  code,
                      data.filter_by =  filter_by
                  } ,
                  type: 'POST'
              },
              "columns": [<?= Eleve::getColumns() ?>],
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
                  "targets": 2,
                  width: '10%', 
                },
                
                {
                  "targets": -2,
                  width: '2%', 
                  "data": null,
                  "render": function(data, type, full, meta){ 
                      // console.log(data);
                      function _calculateAge(birthday) { // birthday is a date
                          var ageDifMs = Date.now() - birthday.getTime();
                          var ageDate = new Date(ageDifMs); // miliseconds from epoch
                          return Math.abs(ageDate.getUTCFullYear() - 1970);
                      }
                      return _calculateAge(new Date(data))
                    }
                },
                {
                  "targets": -1,
                  width: '7%', 
                  "data": null,
                  "render": function(data, type, full, meta){ 
                      // console.log(data);

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

          $('#table-eleve tbody').on( 'click', 'button.action', function () {
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

              switch(action){
                case 'action-voir':
                  modal_eleve_detail(id)
                  // onclick="redirectTo(\''+data.id+'\')"
                  break;
                case 'action-modifier':
                  location.href = '<?= URL::link('eleve_modifier') ?>'+id
                  // redirectTo(id)
                  break;
                case 'action-supprimer':
                  
                    // message de notification
                    swal({
                        title: "Suppression",
                        text: "Voulez vous supprimer ce eleve ?",
                        icon: "warning",
                        showCancelButton: true,
                        buttons: {
                            cancel: {
                                text: "Non, Annuler.",
                                value: null,
                                visible: true,
                                className: "btn-warning",
                                closeModal: true,
                            },
                            confirm: {
                                text: "Oui, Supprimer.",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                            }
                        }
                    }).then(isConfirm => {
                        if (isConfirm) {
                            delete_eleve(id)
                        } else {
                          console.log('annuler')  
                        }
                    });

                  break;
              }

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

