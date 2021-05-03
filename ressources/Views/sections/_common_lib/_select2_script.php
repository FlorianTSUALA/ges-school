<!-- https://jeesite.gitee.io/front/jquery-select2/4.0/index.htm
https://select2.org/programmatic-control/methods -->
<script>
function reset_select2_size(obj)
{
    if (typeof(obj)!='undefined') {
        obj.find('.select2-container').parent().each(function() {
            $(this).find('.select2-container').css({"width":"10px"});
        });

        obj.find('.select2-container').parent().each(function() {
            var width = ($(this).width()-5)+"px";
            $(this).find('.select2-container').css({"width":width});
        });
        return;
    }

    $('.select2-container').filter(':visible').parent().each(function() {
        $(this).find('.select2-container').css({"width":"10px"});
    });
    $('.select2-container').filter(':visible').parent().each(function() {
        var width = ($(this).width()-5)+"px";
        $(this).find('.select2-container').css({"width":width});
    });
}

function onWindowResized( event )
{
    reset_select2_size();
}

window.addEventListener('resize', onWindowResized );

// $('#modal-create, #modal-update, #modal-delete').on('shown.bs.modal', function (event) {
//      onWindowResized( event )
// })


$('.modal').on('shown.bs.modal', function (event) {
     onWindowResized( event )
});

$(document).ready(function(){
     $(".select2-selection span").attr('title', '');

     $('.select2').each(function() { 
          $(this).select2({ dropdownParent: $(this).parent()});
     })
});



</script>


