<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>




<script>
    $('#menu .list-group a.list-group-item').first().addClass('active')
    
    //jQuery > 1.4.3
    let id  = $('#menu .list-group a.list-group-item').first().data('id')

    $('#menu .list-group a.list-group-item').click(function(e) {
      
      $('#menu .list-group a.list-group-item.active').removeClass('active')

      var $current = $(this)
      $current.addClass('active')
      e.preventDefault() 
      apiCall()

    })

    
</script>

<script>

/*=========================================================================================
    File Name: form-duallistbox.js
    Description: Dual list box js
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.1
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
  
	'use strict';

	apiCall()


  // var numb = 25
  // $(".duallistbox-refresh").on('click', function() {
  //   var opt1 = numb + 1
  //   var opt2 = numb + 2
  //   duallistboxDynamic.append('<option value="'+ opt1 +'">London</option><option value="'+ opt2 +'" selected>Rome</option>')
  //   duallistboxDynamic.bootstrapDualListbox('refresh')
  // })





})(window, document, jQuery)
</script>