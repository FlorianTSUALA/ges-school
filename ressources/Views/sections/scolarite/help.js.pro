ajax:{
    url: '<?= URL::link(' api_eleve_all') ?>',
    data: function(data){
        data.code =  code,
        data.filter_by =  filter_by
    } ,
    type: 'POST'
},