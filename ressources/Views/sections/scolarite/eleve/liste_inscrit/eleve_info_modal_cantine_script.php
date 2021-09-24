<?php

use Core\Routing\URL;
?>
<script>
 
 function modal_eleve_detail_cantine(id, nom_complet){
        $.ajax({
            url: '<?= URL::link('eleve_api_info_cantine');?>'+id,
            type: 'post',
            cache: true,
            dataType: 'json',
            beforeSend:function(){
            },
            success:function(data){
                eleve = data
                console.log("data")
                console.log("data")
                console.log("data")
                console.log(data)
               
                var i = 1;
                var html = ''
                for (const item of data) { // You can use `let` instead of `const` if you like
                    console.log(item);

                    html += "<tr>" 
                    html += "   <th>"+(i++)+"</th>" 
                    html += "   <td>"+ item.total +"</td>"
                    html += "   <td>" + item.date_paiement + "</td>"
                    html += "   <td>" +  item.periode  + "</td>"
                    html += "   <td>Actions</td>"
                    html += " <tr>"

                }
                console.log(nom_complet)
                $('#nom_complet').text(nom_complet)
                $("#table-eleve_cantine tbody").html(html)
                $('#eleve_modal_cantine').modal('show')

            },
            error: function (textStatus, errorThrown) {
                Success = false
                swal("Erreur", "Erreur de communication avec le serveur ", "error")
                console.log(textStatus, errorThrown)
            }
        })    
    }

</script>