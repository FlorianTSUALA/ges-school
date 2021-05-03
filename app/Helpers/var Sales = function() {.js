var Sales = function() {

    var handleSave = function() {

        $('#addSales').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                client: {
                    required: true
                    },
                invoice: {
                    required: true,
                    remote: {
                      url: "../assets/custom/check_sales_inv.php",
                      type: "post"
                    }
                },
                inv_date: {
                    required: true
                },
                pr_qty: {
                    required: true
                }
            },

            messages: {
                client: {
                    required: "This field cannot be empty"
                },
                invoice: {
                    required: "This field cannot be empty",
                    remote: "This invoice has been already entered"
                },
                inv_date: {
                    required: "This field cannot be empty"
                }
            },

        });

    }

    var handleUpdate = function() {

        var ajaxUpdate = function(form) {           
            form = $(form);           
            var data = JSON.stringify(form.serializeJSON());
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: data,
                dataType: 'json',
                success:function(response) {
                    if(response.success == true)
                    {
                        updateSalesToast();
                    }
                    else
                    {
                        //$('.alert').show();
                        //$('.alert span').html(response.messages);
                    }

                    //Reset The Form
                    $('#editSales')[0].reset();
                    manageSalesTable.api().ajax.reload(null, false);
                    // close the modal
                    $("#editSalesModal").modal('hide');
                                      
                }
            });

            return false;           
        }
   
   return {
        //main function to initiate the module
        init: function () {           
            handleSave();
            handleUpdate();
        }
    };

}();