<?php

use Core\Routing\URL;
?>
<script>
 
 function modal_eleve_detail_scolarite(id){
        $.ajax({
            url: '<?= URL::link('eleve_api_info_scolarite');?>'+id,
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
                var html_body = ''
                // for()
                alert(data)
                // <tr>
                //   <th>id</th> 
                //   <td>1</td>
                //   <td>premiere tranche</td>
                //   <td>23 fevrier 2014</td>
                //   <td>90 000</td>
                //   <td>Actions</td>
                // <tr>

                $('#eleve_modal_scolarite').modal('show')

            },
            error: function (textStatus, errorThrown) {
                Success = false
                swal("Erreur", "Erreur de communication avec le serveur :)", "error")
                console.log(textStatus, errorThrown)
            }
        })    
    }

</script>