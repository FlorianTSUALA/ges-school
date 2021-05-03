
<script>
      // FOR SEARCH MENU

      function searchMenu(list) {
      
        // https://jsfiddle.net/sofoklis_stouraitis/zLzfpb1u/8/
        // https://stackoverflow.com/questions/2487747/selecting-element-by-data-attribute-with-jquery
        // https://www.w3schools.com/jquery/traversing_closest.asp
        // https://stackoverflow.com/questions/10260667/jquery-get-parent-parent-id
        // bonus https://codepen.io/CodifyAcademy/pen/wzBmXL


        var input = $(".menu-search");
        $(input)
        .change( function () {
          var filter = $(this).val().toUpperCase();
          if(filter) {
            let li = $(list).find("li a");
            for (i = 0; i < li.length; i++) {
              a = li[i]
              if (a.innerText.toUpperCase().indexOf(filter) > -1) {
                
                $(a).parent().children('a').show()
                if($(a).closest('div').hasClass('collapse')){

                  $(a).closest('div').addClass(' show')
                  let id = $(a).closest('div').attr('id')
                  $('[data-target="#'+id+'"]').show()

                }

              } else {
                $(a).parent().children('a').hide()
              }

            }
            
            // not_contains = $(list).find("li a:not(:Contains(" + filter + "))").hide();
            // console.log(not_contains)
            // return
            
            // not_contains.hide().parent().hide()
            // $(list).find("li a:Contains(" + filter + ")").show().parents('li').show().addClass('open').closest('li').children('a').show();
            var searchFilter = $(list).find("li a:Contains(" + filter + ")");
            if( searchFilter.parent().hasClass('has-sub') ){
              searchFilter.show()
              .parents('li').show()
              .addClass('open')
              .closest('li')
              .children('a').show()
              .children('li').show();
              alert('has')
              // searchFilter.parents('li').find('li').show().children('a').show();
              if(searchFilter.siblings('ul').length > 0){
                searchFilter.siblings('ul').children('li').show().children('a').show();
              }
      
            }
            else{
              searchFilter.show().parents('li').show().addClass('open').closest('li').children('a').show();
            }

          } else {
            // return to default
            console.log($('#menu').find("li > a"))
            // $('#menu>li a').hide()
            $('#menu').find("li > a").hide()
            // $('[data-parent="#menu"]').show()
               $('#menu div li a').show()
               $('#menu div div').removeClass('show')

          //--   $('.navigation-header').show();
            // $(list).find("li a").show().parent().show().removeClass('open');
            // alert('empty')
          }
          // $.app.menu.manualScroller.update();
          return false;
        })
        .keyup( function () {
            // fire the above change event after every letter
            $(this).change();
        });
    
      }
      searchMenu('#menu')

</script>
