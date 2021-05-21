<?php

use Core\Routing\URL;
use Core\HTML\Form\InputType;
use App\Model\AbonnementCantine;

include dirname(__DIR__)."/_common_lib/_select2_script.php";

?>
<!--
    ******  VARIABLES *****
     $base_route
     $fillables
     $msg_delete
-->


<script> 

  let msg  = 'Bienvenue à la section des paiement cantine'
  block_notification(msg)

        // C:\laragon\www\ges-school\_robust\_Robust\Robust\Robust\app-assets\js\scripts\pickers\dateTime\pick-a-datetime.js
        var filter_by = 'ALL'
        var start_date = moment()
        var end_date = moment()
        var code = ''

        var printCounter = 0
        var table
        var start = moment()
        var end = moment()

        function getDateStart(){
            console.log(start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))
            return start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )
        }
        
        function getDateEnd(){
            console.log(end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))
            return end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )
        }
        
        function init_data_table() {

            table = $('#table-cantine').DataTable({
                //"serverSide": true,
                //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
                ajax:{
                    url: '<?= URL::link('cantine_abonnement_info') ?>',
                    data: function(data){
                        data.code =  code,
                        data.filter_by = filter_by,
                        data.start_date = start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ),
                        data.end_date = end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )
                    } ,
                    type: 'POST',

                    success: function(msg){
                      console.log("voici le message", msg)
                    }
                },

                
               
            })

            //Reload table data every 30 seconds (paging retained):
            setInterval( function () {
                table.ajax.reload( null, false ); // user paging is not reset on reload
            }, 5550000 );
        }


    (function(window, document, $){

    	// Localization
      $('.localeRange').daterangepicker({
        singleDatePicker: true,
        // ranges: {
        //   "Aujourd'hui": [moment(), moment()],
        //   'Hier': [moment().subtract('days', 1), moment().subtract('days', 1)],
        //   'Demain': [moment().add(1, 'days'), moment().add(1, 'days')],
        //   'Les 7 derniers jours': [moment().subtract('days', 6), moment()],
        //   'Les 7 prochains jours': [moment(), moment().add('days', 6)],
        //   'Les 30 derniers jours': [moment().subtract('days', 29), moment()],
        //   'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
        //   'le mois dernier': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        // },
        locale: {
          applyLabel: "Chercher",
          cancelLabel: 'Annuler',
          startLabel: 'Date initiale',
          endLabel: 'Date limite',
          customRangeLabel: 'Sélectionner une date',
          // daysOfWeek: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi','Samedi'],
          daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve','Sa'],
          monthNames: ['Janvier', 'février', 'Mars', 'Avril', 'Маi', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
          firstDay: 1,
          format: 'DD-MM-YYYY'
        },

      // Max and Min date
      min: [2019,8,20],
      max: [2022,10,30],
        
      // Using Javascript
      // min: new Date(2015,3,20,7),
      // max: new Date(2015,7,14,18,30)

      // formatSubmit: 'dd/mm/yyyy',
      //Buttons class
      drops: "down",
      buttonClasses: "btn",
      applyClass: "btn-info",
      cancelClass: "btn-danger",

      //Events
      onStart: function() {
        console.log('pro - - - > Hi there!!!')
      },
      onRender: function() {
        console.log('pro - - - > Holla... rendered new')
      },
      onOpen: function() {
        console.log('pro - - - > Picker Opened')
      },
      onClose: function() {
        console.log("pro - - - > I'm Closed now")
      },
      onStop: function() {
        console.log('pro - - - > Have a great day ahead!!')
      },
      onSet: function(context) {
        console.log('pro - - - > All stuff:', context)
      }
  }, cb)

  init_data_table()
  
  function cb(start, end) {
    $('#resume_filtre').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    start_date = start
    end_date = end
    console.log(start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))         
    console.log(end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))         
    table.ajax.reload()
    // table.ajax({
    //               url: '<?= URL::link('cantine_abonnement_info') ?>',
    //               data: {
    //                   'code':  code,
    //                   'filter_by': filter_by,
    //                   'start_date': start_date,
    //                   'end_date': end_date
    //               },
    //               type: 'POST'
    //             })
    // table.ajax.url( "<?= URL::link('cantine_abonnement_info')?>?code="+code+"&filter_by="+filter_by+"&start_date="+start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )+"&end_date="+end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ) ).load()
}

  })(window, document, jQuery)
</script>



<script>
// https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_active_element
// Add active class to the current menu item (highlight it)
var menu = document.getElementById("menu");
var links = menu.getElementsByClassName("list-group-item");


for (var i = 0; i < links.length; i++) {
  links[i].addEventListener('click', function() {
      var current = document.getElementsByClassName('active')
      if (current.length > 0) { 
        current[0].className = current[0].className.replace(' active', '')
      }
      this.className += ' active'
      if(this.id.includes('ID_')){
        let current_id = this.id.replace('ID_', '')
        if(current_id.includes('SALL'))
          filter_by ='SALLE_CLASSE'
        else
          filter_by = 'CLASSE'
        code  =  current_id
      }else{
        filter_by = 'ALL'
        code = ''
      }

      start_date = moment()
      end_date = moment()
      // alert(code)
      table.ajax.reload()
  })
}
</script>