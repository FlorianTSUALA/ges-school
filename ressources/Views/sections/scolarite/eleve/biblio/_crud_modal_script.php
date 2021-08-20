<?php

use Core\Routing\URL;
use Core\HTML\Form\InputType;

include dirname(__DIR__)."/_common_lib/_select2_script.php";

?>
<!--
    ******  VARIABLES *****
     $base_route
     $fillables
     $msg_delete
-->


<script>
     (function(){

          $(document).on('click', '#button-create', function(e)
          {
               e.preventDefault();
               form = $('#create-form')[0];
               if (form.checkValidity() === true) {
                    form = $('#create-form');
                    $.ajax({
                         url: "<?= URL::link($base_route.'-create'); ?>",
                         method: "POST",
                         data: form.serialize(),
                         beforeSend:function(){
                              $('#button-form-create').hide();
                              $('#loading').show();
                              $('#notification_msg-create').val('');
                              $('#notification-create').hide();
                         },
                         success:function(data){

                              console.log(data);

                              form[0].reset();
                              $('#button-form-create').show();
                              $('#upt-loading').hide();

                              $('#modal-create').modal('hide');
                              $('#data-table').html(data);
                         },
                         error: function (textStatus, errorThrown) {
                              if(textStatus.status === 300)
                              {
                                   $('#notification_msg-create').html(textStatus.statusText);
                                   $('#notification-create').show();
                                   $('#loading').hide();
                                   $('#button-form-create').show();
                                   console.log(textStatus.statusText);
                              }

                              Success = false;
                         }
                    });
               }else{
                    e.stopPropagation();
                    form.classList.add('was-validated');
               }
          });
     })();
</script>



<!-- update  -->
<script>
     (function(){

          //Get Data to Update
          $('#data-table').on('click', '.btn_update_data', function(e)
          {
               var id = $(this).data("id");
               $.ajax({
                    url: '<?= URL::link($base_route.'-read'); ?>'+id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data){
                         $('#upd-code').val(data.code);
                         console.log(data);
                    <?php
                         $js = '';
                         foreach ($fillables as $fillable) {
                             switch ($fillable->type) {
                                   case InputType::FILE:
                                        $js .= "$('#upd-{$fillable->name}').val(data.{$fillable->name});";
                                   break;
                                   case InputType::DATE:
                                        $js .= "$('#upd-{$fillable->name}').val(moment(new Date(data.{$fillable->name})).format('YYYY-MM-DD'));";
                                   break;
                                   case InputType::DATE_TIME_LOCAL:
                                        $js .= "$('#upd-{$fillable->name}').val(moment(new Date(data.{$fillable->name})).format('YYYY-MM-DD HH-mm-ss'));";
                                   break;
                                   case InputType::TIME:
                                        $js .= "$('#upd-{$fillable->name}').val(moment(new Date(data.{$fillable->name})).format('HH-mm-ss'));";
                                   break;
                                   case InputType::CHECKBOX:
                                        $js .= "$('#upd-{$fillable->name}').val(data.{$fillable->name});";
                                   break;
                                   case InputType::SELECT2:
                                   case InputType::SELECT:
                                        $js .= "$('#upd-{$fillable->name}').val(data.{$fillable->name}).trigger('change');";
                                   break;
                                   case InputType::RADIO:
                                        $js .= " var {$fillable->name} = '#upd-'+data.{$fillable->name}; $({$fillable->name}).prop('checked',true);";
                                   break;
                                   case InputType::TEXT:
                                   case InputType::HIDDEN:
                                   case InputType::PASSWORD:
                                   case InputType::NUMBER:
                                   case InputType::EMAIL:
                                   case InputType::TEXTAREA:
                                   case InputType::TEL:
                                   default:
                                        $js .= "$('#upd-{$fillable->name}').val(data.{$fillable->name});";
                              }
                         }

                         echo "
                         " ;
                         echo $js;
                    ?>

                         $('#modal-update').modal('show');
                    }
               });
          }
          );


          //Store Data
          $('#button-update').click( function(e)
          {
               e.preventDefault();
               form = $('#update-form')[0];
               if (form.checkValidity() === true) {
                    form = $('#update-form');
                    $.ajax({
                         url: '<?= URL::link($base_route.'-update'); ?>'+ $('#upd-code').val(),
                         method: 'POST',
                         data: form.serialize(),
                         beforeSend:function(){
                              $('#button-form-update').hide();
                              $('#upt-loading').show();

                              $('#notification_msg-update').val('');
                              $('#notification-update').hide();
                         },
                         success:function(data){
                              form[0].reset();
                              $('#button-form-update').show();
                              $('#upt-loading').hide();

                              $('#modal-update').modal('hide');
                              $('#data-table').html(data);
                         },
                         error: function (textStatus, errorThrown) {
                              if(textStatus.status === 300)
                              {
                                   $('#notification_msg-update').html(textStatus.statusText);
                                   $('#notification-update').show();
                                   $('#loading').hide();
                                   $('#button-form-update').show();
                                   console.log(textStatus.statusText);
                              }

                              Success = false;
                         }
                    });
               }else{
                    e.stopPropagation();
                    form.classList.add('was-validated');
               }
          });
     })();

</script>



<!-- delete  -->
<script>
     (function(){
          //Display modal delete
          var id = 0;
          $('#data-table').on('click', '.btn_delete_data', function()
          {
               id = $(this).data("id");
               $('#modal-delete').modal('show');
               var $row = $(this).closest("tr"),
               $entity = $row.find("td:nth-child(2)");

               $.each($entity, function() {
                    $('#modal-delete-body').html("<h4> <?= $msg_delete; ?> "+ $(this).text() + ' </strong> ?</h4>');
               });

          });

          //Delete and update table
          $('#button-delete').on('click', function(e)
          {
               //var id = $(this).data("id");
               $.ajax({
                    url: '<?= URL::link($base_route.'-delete'); ?>'+id,
                    method: 'GET',
                    beforeSend:function(){
                              $('#button-form-delete').hide();
                              $('#del-loading').show();
                    },
                    success: function(data){
                         $('#button-form-delete').show();
                         $('#del-loading').hide();

                         $('#modal-delete').modal('hide');
                         $('#data-table').html(data);
                    },
                    error: function (textStatus, errorThrown) {
                              Success = false;
                    }
               });
          });
     })();
</script>



<!-- read  -->
<script>
     (function(){
          $('#data-table').on('click', '.btn_read_data', function(e)
          {
               var id = $(this).data("id");
               $.ajax({
                    url: '<?= URL::link($base_route.'-detail'); ?>'+id,
                    method: 'GET',
                    //dataType: 'json',
                    success: function(data){
                         $("#modal-view-body").html(data);

                         $('#modal-view').modal('show');
                    }
               });
          });
     })();
</script>

