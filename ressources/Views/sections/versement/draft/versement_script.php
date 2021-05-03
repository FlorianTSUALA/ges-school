<?php

use Core\Routing\URL;

?>

<script>
$(document).ready(function(){


$("#eleve_nom_complet").keyup(function(){
    var search = $(this).val();

    if(search != ""){

        $.ajax({
            url: '<?= URL::link('eleve_search_info');?>',
            type: 'post',
            data: {search:search},
            dataType: 'json',
            success:function(response){
            
                var len = response.length;
                $("#live_search_card_result").empty();
                for( var i = 0; i<len; i++){
                    var id = response[i]['id'];
                    var nom = response[i]['nom'];
                    var classe = response[i]['classe'];
                    var date_naissance = response[i]['date_naissance'];
                    var lieu_naissance = response[i]['lieu_naissance'];

                    $("#live_search_card_result").append("<li value='"+id+"'>"+name+"</li>");

                }

                // binding click event to li
                $("#live_search_card_result li").bind("click",function(){
                    setText(this);
                });

            }
        });
    }

});

});

// Set Text to search box and get details
function setText(element){

    var value = $(element).text();
    var code = $(element).val();

    $("#eleve_nom_complet").val(value);
    $("#live_search_card_result").empty();

    // Request User Details
    $.ajax({
        url: '<?= URL::link('eleve_search_detail');?>',
        type: 'post',
        data: {code:code},
        dataType: 'json',
        success: function(response){

            var len = response.length;
            $("#live_search_card_detail").empty();
            if(len > 0){
                var username = response[0]['username'];
                var email = response[0]['email'];
                var email = response[0]['email'];
                var email = response[0]['email'];
                $("#live_search_card_detail").append("Username : " + username + "<br/>");
                $("#live_search_card_detail").append("Username : " + username + "<br/>");
                $("#live_search_card_detail").append("Username : " + username + "<br/>");
                $("#live_search_card_detail").append("Email : " + email);
            }
        }

    });
}
</script>