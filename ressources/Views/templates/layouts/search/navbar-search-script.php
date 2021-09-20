<?php

use Core\Routing\URL;

?>


<script>
    // FOR SEARCH MENU
    //   card-body-default
    //   card-body-search

    function search_menu_v1(list) {
        console.log('Hello World')
        var input = $(list);
        $(input)
            .change(
                function() {
                    var filter = $(this).val().toUpperCase();
                    if (filter) {
                        $('#card-body-default').hide()
                        $('#card-body-search').show()
                        alert('yep')
                    } else {
                        $('#card-body-search').hide()
                        $('#card-body-default').show()
                        alert('yop')
                    }

                    return false;
                }
            )
            .keyup(
                function() {
                    $(this).change();
                }
            );

    }
    // search_menu_v1("#nav_bar_search")
</script>


<script>
    //https://www.bing.com/search?q=live-search-using-ajax-and-phpmysql&cvid=e0a27e15c630444d8ef66321a07decf5&aqs=edge..69i57j69i60.482j0j4&FORM=ANAB01&PC=U531
    //https://www.webslesson.info/2017/02/live-search-json-data-using-ajax-jquery.html
    //https://github.com/codealps/live-search-ajax-php-mysql
    $(document).ready(function() {
        $.ajaxSetup({
            cache: false
        });
        var search = '#nav_bar_search'
        var result = '#result'

        $(search).keyup(function() {
            $(result).html('');
            $('#state').val('');
            var searchField = $(search).val();
            var expression = new RegExp(searchField, "i");
            console.log(expression);
            $.ajax(
                {
                    url: '<?= URL::link('api_post_eleve_search_info'); ?>',
                    method: 'POST',
                    data: {'search' : searchField, 'limit': 100},
                    beforeSend:function(){
                    },
                    success:function(_data){
                        let data = JSON.parse(_data);
                        for(eleve of data) {
                            $(result).append('<li class="list-group-item link-class" > <a href="#" onclick="_modal_eleve_detail(\''+eleve.id+'\')"> <img src="<?= URL::upload() ?>img/eleve/'+ eleve.photo +'"  height="40" width="40" class="img-thumbnail" /> Nom(s) & Prénom(s): ' + eleve.nom + ' ' + eleve.prenom + ' | <span class="text-muted"> Date Nais : ' + eleve.date_naissance + '</span> | <span class="text-muted"> Nationnalité : ' + eleve.pays + '</span></a></li>');
                        }
                    },
                    error: function (textStatus, errorThrown) {
                        if(textStatus.status === 300)
                        {
                            console.log(textStatus.statusText);
                        }

                        Success = false;
                    }
                }
            );
            
        });

        // $(result).on('click', 'li', function() {
        //     var click_text = $(this).text().split('|');
        //     $(search).val($.trim(click_text[0]));
        //     $(result).html('');
        // });
    });
</script>