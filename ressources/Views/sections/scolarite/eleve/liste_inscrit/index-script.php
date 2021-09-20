<?php

use App\Model\Eleve;
use Core\Routing\URL;
use App\Model\Emprunt;
use App\Helpers\Helpers;
use Config\Invariant\API;
use Core\HTML\Form\InputType;

include dirname(dirname(dirname(__DIR__))) . "/_common_lib/_select2_script.php";
?>

<script>
  let msg = 'Bienvenue à la liste des élèves inscrits'
  block_notification(msg)

  var filter_by = 'ALL'
  var code = ''
  var table
 
  (function(window, document, $) {
    init_data_table()
  })(window, document, jQuery)


  function modal_eleve_detail(id){
        $.ajax({
            url: '<?= URL::link('api_eleve_info');?>'+id,
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

                $('#recap-id').text(id)
                $('#recap-email').text(eleve.email)
                $('#recap-telephone').text(eleve.telephone)
                $('#recap-classe').text(eleve.classe)
                $('#recap-ecole').text(eleve.ecole)
                $('#recap-autres').text(eleve.autres)
                $('#recap-probleme_particulier').text(eleve.probleme_particulier)
                $('#recap-email_medecin').text(eleve.email_medecin)
                $('#recap-telephone_medecin').text(eleve.telephone_medecin)
                $('#recap-nom_medecin').text(eleve.nom_medecin)
                $('#recap-maladie_recurrente').text(eleve.maladie_recurrente)
                $('#recap-allergie').text(eleve.allergie)
                $('#recap-email_mere').text(eleve.email_mere)
                $('#recap-bureau_mere').text(eleve.bureau_mere)
                $('#recap-quartier_mere').text(eleve.quartier_mere)
                $('#recap-telephone_mere').text(eleve.telephone_mere)
                $('#recap-lieu_travail_mere').text(eleve.lieu_travail_mere)
                $('#recap-profession_mere').text(eleve.profession_mere)
                $('#recap-employeur_mere').text(eleve.employeur_mere)
                $('#recap-prenom_mere').text(eleve.prenom_mere)
                $('#recap-nom_mere').text(eleve.nom_mere)
                $('#recap-telephone_personne_urgence').text(eleve.telephone_personne_urgence)
                $('#recap-nom_personne_urgence').text(eleve.nom_personne_urgence)
                $('#recap-prenom_personne_urgence').text(eleve.prenom_personne_urgence)
                $('#recap-lien').text(eleve.lien)
                $('#recap-nom_eleve').text(eleve.nom)
                $('#recap-nom_usage').text(eleve.nom_usage)
                $('#recap-prenom_eleve').text(eleve.prenom)
                $('#recap-prenom_usage').text(eleve.prenom_usage)
                $('#recap-lieu_naissance_eleve').text(eleve.lieu_naissance)
                $('#recap-date_naissance_eleve').text(eleve.date_naissance)
                $('#recap-anciennete_eleve').text(eleve.anciennete)
                $('#recap-nom_pere').text(eleve.nom_pere)
                $('#recap-prenom_pere').text(eleve.prenom_pere)
                $('#recap-employeur_pere').text(eleve.employeur_pere)
                $('#recap-profession_pere').text(eleve.profession_pere)
                $('#recap-lieu_travail_pere').text(eleve.lieu_travail_pere)
                $('#recap-telephone_pere').text(eleve.telephone_pere)
                $('#recap-bureau_pere').text(eleve.bureau_pere)
                $('#recap-quartier_pere').text(eleve.quartier_pere)
                $('#recap-email_pere').text(eleve.email_pere)



                $('#recap-pays_eleve').text(eleve.pays)
                $('#recap-statut_eleve').text(eleve.statut_eleve)
                $('#recap-classe_eleve').text(eleve.classe_eleve)
                $('#recap-salle_classe_eleve').text(eleve.salle_classe_eleve)
                // $('#recap-annee_scolaire').text(eleve.annee_scolaire)
                //$('#recap-pays_pere').text(eleve.pays_pere)
                // $('#recap-pays_mere').text(eleve.pays_mere)
                $('#recap-groupe_sanguin').text(eleve.groupe_sanguin)


                $("#recap-sexe_eleve").text( (eleve.sexe == 'M')? 'Masculin' : 'Féminin' )
                $("#recap-photo").attr('src', "<?= URL::upload() ?>img/eleve/"+eleve.photo)

                $('#recap-pieces_jointes').on('click', function(e) {
                    download("<?= URL::upload() ?>img/eleve/"+eleve.pieces_jointes)
                })

                $('#eleve_modal_info_inscrit').modal('show')

            },
            error: function (textStatus, errorThrown) {
                Success = false
                swal("Erreur", "Erreur de communication avec le serveur :)", "error")
                console.log(textStatus, errorThrown)
            }
        })    
    }

  function init_data_table() {
    // $('#table-eleve').append('<caption style="caption-side: top-right">Table caption</caption>');

    table = $('#table-eleve').DataTable({
      //"serverSide": true,
      //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
      ajax: {
        url: '<?= URL::link('eleve_api_eleve_inscrit') ?>',
        data: function(data) {
          data.code = code,
            data.filter_by = filter_by
        },
        type: 'POST'
      },
      "columns": [<?= Eleve::getColumns("table_eleve_inscrit") ?>],
     // console.log()
      order: [
        [1, 'asc']
      ],
      scrollY: "700px",
      scrollX: true,
      scrollCollapse: true,
      // paging:         false,
      fixedColumns: true,
      "columnDefs": [{
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
          width: '3%',
          "data": null,
          "render": function(data, type, full, meta) {
            const date = new Date(data).toLocaleDateString(window.navigator.language, {
              year: 'numeric',
              month: 'long',
              day: 'numeric',
            });
            return date
          }
        },
        {
          "targets": -1,
          "data": null,
          "render": function(data, type, full, meta){ 
                        return '  '+
                                    '<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="fa fa-cog"></i></button> <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">  ' +
                                    '<a href="#" class="dropdown-item action action-voir" data-action="action-voir" data-id="'+data.id+'"  ><i class="ft-eye"></i> voir</a>' +
                                    '<a href="#" class="dropdown-item action action-modifier" data-action="action-modifier"  data-id="'+data.id+'"  ><i class="ft-edit-2"></i> modifier</a>' +
                                    '<a href="#" class="dropdown-item action action-scolarite" data-action="action-scolarite"  data-id="'+data.id+'"  ><i class="ft-check"></i> scolarité</a>' +
                                    '<a href="#" class="dropdown-item action action-cantine" data-action="action-cantine" data-id="'+data.id+'"  ><i class="ft-upload"></i> cantine</a>' +
                                    '<a href="#" class="dropdown-item action action-activite" data-action="action-activite" data-id="'+data.id+'"  ><i class="ft-upload"></i> activité</a>' +
                                    '<a href="#" class="dropdown-item action action-affectation" data-action="action-affectation"  data-id="'+data.id+'"  ><i class="ft-upload"></i> affecter</a>' +
                                    '<a href="#" class="dropdown-item action action-supprimer" data-action="action-supprimer"  data-id="'+data.id+'"  ><i class="ft-trash"></i> supprimer</a>  </span>' 
          },
        }
      ],
      "createdRow": function(row, data, index) {
        // let date = new Date(data.date).toLocaleDateString(window.navigator.language, {year: 'numeric',month: 'long',day: 'numeric',});
      },
      "fnDrawCallback": function(oSettings) {
        // $('#table-emprunt').append('<caption style="caption-side: top-right">Table caption</caption>');
      },
      <?= Helpers::dataTableCommunOptions() ?>
      dom: "<'d-flex justify-content-between'<'p-2'l><'p-2'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      renderer: 'bootstrap',
      // "destroy" : true,
      // dom: 'Blfrtip',
      // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
      stateSave: true,

    })

    table.on('order.dt search.dt', function() {
      table.column(0, {
        search: 'applied',
        order: 'applied'
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#table-eleve tbody').on('click', 'a.action', function() {
       // var id = $(this).data('id');
       var action = $(this).data('action');
              console.log(action)
              var data = table.row( $(this).parents('tr') ).data()
              console.log(data)
              console.log(data['nom_complet'] )
              let id = data.id
              // console.log(data)
              console.log(id)

              switch(action){
                case 'action-voir':
                  console.log("voir")
                  modal_eleve_detail(id)
                  break;
                case 'action-scolarite':
                  console.log("scolarite")
                  modal_eleve_detail_scolarite(id,data.nom_complet)
                  break;                
                case 'action-cantine':
                  console.log("cantine")
                  modal_eleve_detail_cantine(id,data.nom_complet )
                  break;
                case 'action-activite':
                  console.log("activite11")
                  modal_eleve_detail_activite(id,data.nom_complet)
                  break;
                case 'action-modifier':
                  location.href = '<?= URL::link('eleve_modifier') ?>'+id
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
    })


  }

  //Reload table data every 30 seconds (paging retained):
  setInterval(function() {
    table.ajax.reload(null, false); // user paging is not reset on reload
  }, <?= REFRESH_TIME_DATATABLE ?>);


</script>


<script>
  $('#menu .list-group a.list-group-item').click(function(e) {
    $('#menu .list-group a.list-group-item.active').removeClass('active');
    var $current = $(this)
    $current.addClass('active');
    e.preventDefault();
    if (this.id.includes('ID_')) {
      let current_id = this.id.replace('ID_', '')
      code = current_id
      filter_by = 'classe'
    } else {
      filter_by = 'ALL'
      code = ''
    }
    console.log(code)

    table.ajax.reload()
  });
</script>


<script>
  function imprimer_facture(){
    let _code = (code == '')? 'ALL' : code;
    let url = '<?= URL::link('api_facture_eleve_liste_inscrit');?>'+_code
    window.open(url, '_blank').focus();
  }
</script>