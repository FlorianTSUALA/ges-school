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

  let msg  = 'Bienvenue à la section qui liste de tous les élèves de l\'établissement'
  block_notification(msg)

    function redirectTo(id = false){
        id = (id == false) ? $('#recap-id').text(): id;
        location.href = '<?= URL::link('eleve_modifier') ?>'+id
    }

    function modal_eleve_detail(id){
        $.ajax({
            url: '<?= URL::link('eleve_api_info');?>'+id,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
            },
            success:function(data){
                eleve = data
                console.log("data")
                console.log("data")
                console.log("data")
                console.log(data)

                $('#recap-email').text($('#email').val() ? $('#email').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-telephone').text($('#telephone').val() ? $('#telephone').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-classe').text($('#classe').val() ? $('#classe').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-ecole').text($('#ecole').val() ? $('#ecole').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-autres').text($('#autres').val() ? $('#autres').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-probleme_particulier').text($('#probleme_particulier').val() ? $('#probleme_particulier').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-email_medecin').text($('#email_medecin').val() ? $('#email_medecin').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-telephone_medecin').text($('#telephone_medecin').val() ? $('#telephone_medecin').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-nom_medecin').text($('#nom_medecin').val() ? $('#nom_medecin').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-maladie_recurrente').text($('#maladie_recurrente').val() ? $('#maladie_recurrente').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-allergie').text($('#allergie').val() ? $('#allergie').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-email_mere').text($('#email_mere').val() ? $('#email_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-bureau_mere').text($('#bureau_mere').val() ? $('#bureau_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-quartier_mere').text($('#quartier_mere').val() ? $('#quartier_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-telephone_mere').text($('#telephone_mere').val() ? $('#telephone_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-lieu_travail_mere').text($('#lieu_travail_mere').val() ? $('#lieu_travail_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-profession_mere').text($('#profession_mere').val() ? $('#profession_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-employeur_mere').text($('#employeur_mere').val() ? $('#employeur_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-prenom_mere').text($('#prenom_mere').val() ? $('#prenom_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-nom_mere').text($('#nom_mere').val() ? $('#nom_mere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-telephone_personne_urgence').text($('#telephone_personne_urgence').val() ? $('#telephone_personne_urgence').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-nom_personne_urgence').text($('#nom_personne_urgence').val() ? $('#nom_personne_urgence').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-prenom_personne_urgence').text($('#prenom_personne_urgence').val() ? $('#prenom_personne_urgence').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-lien').text($('#lien').val() ? $('#lien').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-nom_eleve').text($('#nom_eleve').val() ? $('#nom_eleve').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-nom_usage').text($('#nom_usage').val() ? $('#nom_usage').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-prenom_eleve').text($('#prenom_eleve').val() ? $('#prenom_eleve').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-prenom_usage').text($('#prenom_usage').val() ? $('#prenom_usage').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-lieu_naissance_eleve').text($('#lieu_naissance_eleve').val() ? $('#lieu_naissance_eleve').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-date_naissance_eleve').text($('#date_naissance_eleve').val() ? $('#date_naissance_eleve').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-anciennete_eleve').text($('#anciennete_eleve').val() ? $('#anciennete_eleve').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-nom_pere').text($('#nom_pere').val() ? $('#nom_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-prenom_pere').text($('#prenom_pere').val() ? $('#prenom_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-employeur_pere').text($('#employeur_pere').val() ? $('#employeur_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-profession_pere').text($('#profession_pere').val() ? $('#profession_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-lieu_travail_pere').text($('#lieu_travail_pere').val() ? $('#lieu_travail_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-telephone_pere').text($('#telephone_pere').val() ? $('#telephone_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-bureau_pere').text($('#bureau_pere').val() ? $('#bureau_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-quartier_pere').text($('#quartier_pere').val() ? $('#quartier_pere').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-email_pere').text($('#email_pere').val() ? $('#email_pere').val() : '<?= Helpers::repeatChar(); ?>');



                $('#recap-pays_eleve').text($('#pays_eleve :selected').val() ? $('#pays_eleve :selected').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-statut_apprenant_eleve').text($('#statut_apprenant_eleve :selected').val() ? $('#statut_apprenant_eleve :selected').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-classe_eleve').text($('#classe_eleve :selected').val() ? $('#classe_eleve :selected').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-salle_classe_eleve').text($('#salle_classe_eleve :selected').val() ? $('#salle_classe_eleve :selected').val() : '<?= Helpers::repeatChar(); ?>');
                // $('#recap-annee_scolaire').text($('#annee_scolaire :selected').val()? $('#annee_scolaire :selected').val() : '<?= Helpers::repeatChar(); ?>');
                //$('#recap-pays_pere').text($('#pays_pere :selected').val()? $('#pays_pere :selected').val() : '<?= Helpers::repeatChar(); ?>'); 
                // $('#recap-pays_mere').text($('#pays_mere :selected').val()? $('#pays_mere :selected').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-groupe_sanguin').text($('#groupe_sanguin :selected').val() ? $('#groupe_sanguin :selected').val() : '<?= Helpers::repeatChar(); ?>');

                // $('#recap-est_tuteur_pere').text($('input[type=radio][name=est_tuteur_pere]:checked').val()? $('input[type=radio][name=est_tuteur_pere]:checked').val() : '<?= Helpers::repeatChar(); ?>');
                // $('#recap-est_tuteur_mere').text($('input[type=radio][name=est_tuteur_mere]:checked').val()? $('input[type=radio][name=est_tuteur_mere]:checked').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-sexe_eleve').text($('input[type=radio][name=sexe_eleve]:checked').val() ? $('input[type=radio][name=sexe_eleve]:checked').val() : '<?= Helpers::repeatChar(); ?>');
                $('#recap-sexe_eleve').val($('input[type=radio][name=sexe_eleve]:checked').val() ? $('input[type=radio][name=sexe_eleve]:checked').val() : '<?= Helpers::repeatChar(); ?>');


                $("#recap-id").text(eleve.id)
                $("#recap-nom").text(eleve.nom)
                $("#recap-prenom").text(eleve.prenom)
                $("#recap-telephone").text(eleve.telephone)
                $("#recap-email").text(eleve.email)
                $("#recap-date_prise_service").text(eleve.date_prise_service)
                $("#recap-adresse").text(eleve.adresse)
                $("#recap-pays").text(eleve.pays)
                $("#recap-type_eleve").text(eleve.type_eleve)
                $("#recap-login").text(eleve.login)
                $("#recap-sexe").text( (eleve.sexe == 'H')? 'Masculin' : 'Féminin' )
                $("#recap-assurance").text(eleve.assurance)
                $("#recap-autres").text(eleve.autres)
                $("#recap-fonciton").text(eleve.fonction)
                $("#recap-salle_classe").text(eleve.salle_classe)
                $("#recap-photo").attr('src', "<?= URL::upload() ?>ressources/uploads/img/eleve/"+eleve.photo)

                $('#recap-pieces_jointes').on('click', function(e) {
                    download("<?= URL::upload() ?>ressources/uploads/img/eleve/"+eleve.pieces_jointes)
                })

                $('#eleve_modal_info').modal('show')

            },
            error: function (textStatus, errorThrown) {
                Success = false
                swal("Erreur", "Erreur de communication avec le serveur :)", "error")
                console.log(textStatus, errorThrown)
            }
        })    
    }

    
  function delete_eleve(id){
      $.ajax({
          url: '<?= URL::link('eleve_api_delete_eleve');?>'+id,
          type: 'post',
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

