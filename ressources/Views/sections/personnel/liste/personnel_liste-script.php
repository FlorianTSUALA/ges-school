<?php

use Core\Routing\URL;
use App\Helpers\Helpers;
use App\Model\Personnel;

include dirname(dirname(__DIR__))."/_common_lib/_select2_script.php";

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

  let msg  = 'Bienvenue à la gestion du Personnel'
  block_notification(msg)

    function redirectTo(id = false){
        // console.log(id)
        id = (id == false) ? $('#recap-id').text(): id;
        // console.log(id)
        location.href = '<?= URL::link('modifier_personnel') ?>'+id
    }

    function initDataModal(id){
        $.ajax({
            url: '<?= URL::link('personnel_api_info');?>'+id,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
            },
            success:function(data){
                console.log(data)

                personnel = data
                $("#recap-id").text(personnel.id)
                $("#recap-nom").text(personnel.nom)
                $("#recap-prenom").text(personnel.prenom)
                $("#recap-telephone").text(personnel.telephone)
                $("#recap-email").text(personnel.email)
                $("#recap-date_prise_service").text(personnel.date_prise_service)
                $("#recap-adresse").text(personnel.adresse)
                $("#recap-pays").text(personnel.pays)
                $("#recap-type_personnel").text(personnel.type_personnel)
                $("#recap-login").text(personnel.login)
                $("#recap-sexe").text( (personnel.sexe == 'H')? 'Masculin' : 'Féminin' )
                $("#recap-assurance").text(personnel.assurance)
                $("#recap-autres").text(personnel.autres)
                $("#recap-fonciton").text(personnel.fonction)
                $("#recap-salle_classe").text(personnel.salle_classe)
                $("#recap-photo").attr('src', "<?= URL::upload() ?>ressources/uploads/img/personnel/"+personnel.photo)

                $('#recap-pieces_jointes').on('click', function(e) {
                    download("<?= URL::upload() ?>ressources/uploads/img/personnel/"+personnel.pieces_jointes)
                })

                $('#personnel_modal_info').modal('show')

            },
            error: function (textStatus, errorThrown) {
                Success = false
                swal("Erreur", "Erreur de communication avec le serveur :)", "error")
                console.log(textStatus, errorThrown)
            }
        })    
    }

  function init_data_table() {
        // $('#table-personnel').append('<caption style="caption-side: top-right">Table caption</caption>');

          table = $('#table-personnel').DataTable({
              //"serverSide": true,
              //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
              ajax:{
                  url: '<?= URL::link('personnel_api_get_all') ?>',
                  data: function(data){
                      data.code =  code,
                      data.filter_by =  filter_by
                  } ,
                  type: 'POST'
              },
              "columns": [<?= Personnel::getColumns() ?>],
             
             
              order: [[ 1, 'asc' ]],
              scrollY:        "300px",
              scrollX:        true,
              scrollCollapse: true,
              // paging:         false,
              fixedColumns: true,
              "columnDefs": [
                {
                  "targets": 0,
                  width: '5%',
                  "searchable": false,
                  // "orderable": false,
                  "class": "index",
                   
                },      
                
                {
                  "targets": -1,
                  width: '7%', 
                  "data": null,
                  "render": function(data, type, full, meta){ 
                      // console.log(data);
                        return  ' '+
                                ' <div class="btn-group" role="group" aria-label="Basic example"> '+
                                '      <button type="button" data-action="action-voir" class="action btn btn-sm btn-icon btn-primary mr-0" title="voir"><i class="ft-eye"></i></button> '+
                                '      <button type="button" data-action="action-modifier" class="action btn btn-sm btn-icon btn-success mr-0" title="modifier"><i class="ft-edit-2"></i></button> '+
                                '      <button type="button" data-action="action-supprimer" class="action btn btn-sm btn-icon btn-warning mr-0" title="supprimer"><i class="ft-trash"></i></button> '+
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

          $('#table-personnel tbody').on( 'click', 'button.action', function () {
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
                  initDataModal(id)
                  // onclick="redirectTo(\''+data.id+'\')"
                  break;
                case 'action-modifier':
                  location.href = '<?= URL::link('modifier_personnel') ?>'+id
                  // redirectTo(id)
                  break;
                case 'action-supprimer':
                  
                    // message de notification
                    swal({
                        title: "Suppression",
                        text: "Voulez vous supprimer ce personnel ?",
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
                            deleteItem(id)
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



<script>

$('#menu .list-group a.list-group-item').click(function(e) {
  $('#menu .list-group a.list-group-item.active').removeClass('active');
  var $current = $(this)
  $current.addClass('active');
  e.preventDefault();
  if(this.id.includes('ID_')){
    let current_id = this.id.replace('ID_', '')
    code  =  current_id
    filter_by = 'type_personnel'
  }else{
    filter_by = 'ALL'
    code = ''
  }
  console.log(code)

  table.ajax.reload()
});

</script>