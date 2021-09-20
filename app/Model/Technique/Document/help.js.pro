ajax:{
    url: '<?= URL::link(' api_eleve_all') ?>',
    data: function(data){
        data.code =  code,
        data.filter_by =  filter_by
    } ,
    type: 'POST'
}

$("#recap-photo").attr('src', "<?= URL::upload() ?>img/eleve/"+eleve.photo)


$('#mySelect2').val(null).trigger('change');

$(document).ready(function() {
    $("#state").select2({
      tags: true
    });
      
    $("#btn-add-state").on("click", function(){
      var newStateVal = $("#new-state").val();
      // Set the value, creating a new option if necessary
      if ($("#state").find("option[value='" + newStateVal + "']").length) {
        //$("#state").val(newStateVal).trigger("change");
      } else { 
        // Create the DOM option that is pre-selected by default
        var newState = new Option(newStateVal+'ok', newStateVal, true, true);
        // Append it to the select
        $("#state").append(newState).trigger('change');
      } 
    });  
});



var data = {
    id: 1,
    text: 'Barn owl'
};

var newOption = new Option(data.text, data.id, false, false);
$('#mySelect2').append(newOption).trigger('change');

$('#mySelect2').val(null).trigger('change');

$('#mySelect2').empty().trigger("change");

function openInNewTab(url) {
  window.open(url, '_blank').focus();
 }